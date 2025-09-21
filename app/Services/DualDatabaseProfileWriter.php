<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\Authenticatable;
use Throwable;
use App\Models\User; // pastikan ini namespace model User-mu

class DualDatabaseProfileWriter
{
    public function updateProfile(
        Authenticatable $authUser,
        array $payload,
        string $originalEmail,
    ): void {
        $targetEmail = $payload['email'];
        $username    = $payload['username'] ?? null;
        $newPassword = $payload['password'] ?? null;

        $this->assertEmailUniqueAcrossConnections($originalEmail, $targetEmail);

        $hashed = $newPassword ? Hash::make($newPassword) : null;

        $core   = DB::connection('hcpm');   // CORE
        $portal = DB::connection('mysql');  // PORTAL

        $core->beginTransaction();
        $portal->beginTransaction();

        try {
            // CORE
            $coreUpdate = [
                'email'      => $targetEmail,
                'updated_at' => now(),
            ];
            if ($username !== null) $coreUpdate['username'] = $username;
            if ($hashed) $coreUpdate['password'] = $hashed;

            $affectedCore = $core->table('users')
                ->where('email', $originalEmail)
                ->update($coreUpdate);

            if ($affectedCore === 0) {
                throw new \RuntimeException('User tidak ditemukan di DB core (hcpm).');
            }

            // PORTAL
            $portalUpdate = [
                'email'      => $targetEmail,
                'updated_at' => now(),
            ];
            if ($username !== null) $portalUpdate['username'] = $username;
            if ($hashed) $portalUpdate['password'] = $hashed;

            $affectedPortal = $portal->table('users')
                ->where('email', $originalEmail)
                ->update($portalUpdate);

            if ($affectedPortal === 0) {
                throw new \RuntimeException('User tidak ditemukan di DB portal (mysql).');
            }

            $core->commit();
            $portal->commit();

            // === Refresh user yang sedang login ===
            // Ambil dari portal (koneksi default Eloquent biasanya "mysql")
            $fresh = User::query()->where('email', $targetEmail)->first();
            if ($fresh) {
                Auth::setUser($fresh);
                // optional: regenerate session untuk keamanan setelah ganti password/email
                request()->session()->regenerate();
            }

        } catch (Throwable $e) {
            static::safeRollback($core);
            static::safeRollback($portal);
            report($e);
            throw $e;
        } finally {
            $core->disconnect();
            $portal->disconnect();
        }
    }

    protected function assertEmailUniqueAcrossConnections(string $originalEmail, string $targetEmail): void
    {
        if ($originalEmail === $targetEmail) return;

        $existsCore = DB::connection('hcpm')->table('users')
            ->where('email', $targetEmail)
            ->exists();

        if ($existsCore) {
            throw new \InvalidArgumentException('Email sudah dipakai di database core.');
        }

        $existsPortal = DB::connection('mysql')->table('users')
            ->where('email', $targetEmail)
            ->exists();

        if ($existsPortal) {
            throw new \InvalidArgumentException('Email sudah dipakai di database portal.');
        }
    }

    protected static function safeRollback($conn): void
    {
        try {
            if ($conn->transactionLevel() > 0) {
                $conn->rollBack();
            }
        } catch (Throwable $ignored) {}
    }
}
