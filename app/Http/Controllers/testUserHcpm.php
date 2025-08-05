<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\HcpmUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class testUserHcpm extends Controller
{
    public function index()
    {
        $users = HcpmUser::with(['jobTitles', 'jobDetail'])->get();
        return view('test.hcpm-users', compact('users'));
    }

    public function show($id)
    {
        $user = HcpmUser::with([
            'JobTitles',
            'jobDetail',
            'smartnakamaProfile',
            'department',
            'salaryDetails',
            'terminationDetails',
            'contactDetails',
            'emergencyDetails',
            'personalDetails',
            'educationBackgrounds',
            'careerExperiences',
            'competencySpecifications',
            'certifications',
        ])->findOrFail($id);


        return view('test.user-profile', compact('user'));
    }
    public function portalUser()
    {
        $users = User::with('roles')->get();

        return view('test.portal-users', compact('users'));

    }
    public function setSuperAdmin(string $email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response("User dengan email $email tidak ditemukan.", 404);
        }

        $user->syncRoles(['super_admin']);

        return response("Role user $email berhasil diubah menjadi super_admin.");
    }
    public function resetPasswordToDefault(string $email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response("User dengan email $email tidak ditemukan.", 404);
        }

        $user->password = bcrypt('12345678');
        $user->save();

        return response("Password user $email berhasil di-reset ke default (12345678).");
    }

    public function syncToPortal()
    {
        ini_set('max_execution_time', 300); // 5 menit

        $synced = 0;
        $updated = 0;

        $hcpmUsers = HcpmUser::with('jobDetail')->get(); // 👈 load relasi yg benar
        
        foreach ($hcpmUsers as $hcpm) {
            $status = $hcpm->status; // 👈 pakai accessor yang sudah betul

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
                    $user->email === 'puremachine99@gmail.com' ? ['super_admin'] : ['Smartnakama']
                );

                $synced++;
            } else {
                $user->update([
                    'hcpm_status' => $status,
                ]);

                $updated++;
            }
        }

        return response()->json([
            'message' => 'Sync selesai',
            'new_users_synced' => $synced,
            'existing_users_updated' => $updated,
        ]);
    }

}
