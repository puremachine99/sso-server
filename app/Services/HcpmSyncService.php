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
                $user = User::create([
                    'name' => $hcpm->name,
                    'email' => $hcpm->email,
                    'password' => bcrypt('12345678'),
                    'source' => 'synced user',
                    'hcpm_status' => $status,
                ]);

                $user->syncRoles(
                    $user->email === 'puremachine99@gmail.com' ? ['super_admin'] : ['smartnakama']
                );

                $synced++;
            } else {
                $user->update(['hcpm_status' => $status]);
                $updated++;
            }
        }

        return compact('synced', 'updated');
    }
}
