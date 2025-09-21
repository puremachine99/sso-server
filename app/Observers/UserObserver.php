<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserObserver
{
    /**
     * Pre-commit: tulis ke HCPM dulu. Kalau gagal -> lempar error -> portal rollback.
     */
    public function updating(User $user): void
    {
        // field yang relevan di portal: name, email, password
        $dirty = [];
        foreach (['name', 'email', 'password'] as $f) {
            if ($user->isDirty($f)) $dirty[$f] = true;
        }
        if (empty($dirty)) return;

        $originalEmail = $user->getOriginal('email'); // locator HCPM
        $targetEmail   = $user->email;

        // siapkan update untuk HCPM (username TIDAK diubah)
        $update = ['updated_at' => now()];
        if (!empty($dirty['name']))     $update['name']     = $user->name;
        if (!empty($dirty['email']))    $update['email']    = $targetEmail;   // boleh null di HCPM
        if (!empty($dirty['password'])) $update['password'] = $user->password; // sudah hashed

        // Jika email berubah & tidak null, cek unik di HCPM
        if (!empty($dirty['email']) && $targetEmail !== null && $originalEmail !== $targetEmail) {
            $existsCore = DB::connection('hcpm')->table('users')
                ->whereNotNull('email')
                ->where('email', $targetEmail)
                ->exists();
            if ($existsCore) {
                throw new \InvalidArgumentException('Email sudah dipakai di database core (HCPM).');
            }
        }

        $core = DB::connection('hcpm');
        $core->beginTransaction();

        try {
            // Locator pakai email lama; jika email lama null, fallback ke locator lain sesuai kebutuhan
            $query = $core->table('users');
            if ($originalEmail !== null) {
                $query->where('email', $originalEmail);
            } else {
                // fallback: kalau email lama null, jangan ambil risiko — hentikan
                throw new \RuntimeException('Tidak bisa menyocokkan user di HCPM karena email lama NULL.');
            }

            $affected = $query->update($update);

            if ($affected === 0) {
                throw new \RuntimeException('User tidak ditemukan di HCPM berdasarkan email lama.');
            }

            $core->commit();
        } catch (Throwable $e) {
            if ($core->transactionLevel() > 0) $core->rollBack();
            throw $e; // batalkan simpan di portal
        } finally {
            $core->disconnect();
        }
    }

    /**
     * Post-commit portal: aman untuk logging.
     */
    public function updated(User $user): void
    {
        try {
            $changed = array_keys($user->getChanges());
            $flags = [
                'name'     => in_array('name', $changed, true),
                'email'    => in_array('email', $changed, true),
                'password' => in_array('password', $changed, true),
            ];

            if (in_array(true, $flags, true)) {
                \App\Support\ActivityLogger::log(
                    $flags['password'] ? 'user.password.updated' : 'user.updated',
                    $flags['password'] ? 'Password updated' : 'User profile updated',
                    $user,
                    [
                        'fields' => array_keys(array_filter($flags)),
                        'updated_by' => optional(Auth::user())->id,
                    ],
                    Auth::user()
                );
            }
        } catch (\Throwable $e) {
            // jangan ganggu flow utama
        }
    }
}
