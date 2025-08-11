<?php

namespace App\Services;

use App\Models\User;
use App\Models\HcpmUser;

class HcpmSyncService
{
    public function syncAll(): array
    {
        // mlsn.b47603a2e4c0d278f73f8ce5c6127b579cd4fd3df792736dd6a23d0d8bd6f91b
        ini_set('max_execution_time', 300); // 5 menit
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
