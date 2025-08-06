<?php

namespace App\Services;

use App\Models\User;
use App\Models\HcpmUser;

class HcpmSyncService
{
    public function syncAll(): array
    {
        $synced = 0;
        $updated = 0;

        $hcpmUsers = HcpmUser::with('jobDetail')->get();

        foreach ($hcpmUsers as $hcpm) {
            $status = $hcpm->status;

            /** @var \App\Models\User|null $user */
            $user = User::where('email', $hcpm->email)->first();

            // Mapping data dari HCPM ke struktur User
            $newUserData = [
                'name' => $hcpm->name,
                'email' => $hcpm->email,
                'password' => bcrypt($hcpm->password), // pastikan dari plaintext
                'source' => 'synced user',
                'hcpm_status' => $status,
            ];

            if (!$user) {
                // Buat user baru
                $user = User::create($newUserData);

                $user->syncRoles(
                    $user->email === 'puremachine99@gmail.com'
                    ? ['super_admin']
                    : ['smartnakama']
                );

                $synced++;
            } else {
                // Bandingkan setiap field dari data yang disediakan
                $changes = [];

                foreach ($newUserData as $key => $value) {
                    // Skip password comparison karena hash selalu beda
                    if ($key === 'password') {
                        continue;
                    }

                    if ($user->{$key} !== $value) {
                        $changes[$key] = $value;
                    }
                }

                if (!empty($changes)) {
                    $user->update($changes);
                    $updated++;
                }
            }
        }

        return compact('synced', 'updated');
    }

}
