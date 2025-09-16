<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // Sinkronisasi password ke HCPM jika berubah
        if ($user->wasChanged('password')) {
            DB::connection('hcpm')->table('users')
                ->where('email', $user->email)
                ->update([
                    'password' => $user->password,
                    'updated_at' => now(),
                ]);
        }

        // Catat activity perubahan profil / password
        try {
            $changed = array_keys($user->getChanges());
            // Jangan bocorkan nilai, cukup field apa yang berubah
            $flags = [
                'name' => in_array('name', $changed, true),
                'email' => in_array('email', $changed, true),
                'password' => in_array('password', $changed, true),
            ];

            if (in_array(true, $flags, true)) {
                \App\Support\ActivityLogger::log(
                    $flags['password'] ? 'user.password.updated' : 'user.updated',
                    $flags['password'] ? 'Password updated' : 'User profile updated',
                    $user,
                    [
                        'fields' => array_keys(array_filter($flags)),
                        'updated_by' => optional(auth()->user())->id,
                    ],
                    auth()->user()
                );
            }
        } catch (\Throwable $e) {
            // jangan ganggu flow utama
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
