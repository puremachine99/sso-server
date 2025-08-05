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

            $user = User::where('email', $hcpm->email)->first();

            if (!$user) {
                // Buat baru full dari HCPM
                $user = User::create([
                    'name' => $hcpm->name,
                    'email' => $hcpm->email,
                    'password' => bcrypt('12345678'),
                    'source' => 'synced user',
                    'hcpm_status' => $status,
                    'department_id' => $hcpm->department_id ?? null,
                    'username' => $hcpm->username ?? null,
                ]);

                $user->syncRoles(
                    $user->email === 'puremachine99@gmail.com' ? ['super_admin'] : ['smartnakama']
                );

                $synced++;
            } else {
                // Update semua kolom kecuali email & name
                $needsUpdate = false;

                $fieldsToSync = [
                    'username' => $hcpm->username ?? null,
                    'department_id' => $hcpm->department_id ?? null,
                    'hcpm_status' => $status,
                    'source' => 'synced user',
                    'password' => bcrypt('12345678'), // default sync password setiap sync
                ];

                foreach ($fieldsToSync as $column => $newValue) {
                    if ($user->$column !== $newValue) {
                        $user->$column = $newValue;
                        $needsUpdate = true;
                    }
                }

                if ($needsUpdate) {
                    $user->save();
                    $updated++;
                }
            }
        }

        return compact('synced', 'updated');
    }

}
