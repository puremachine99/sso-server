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

    public function syncToPortal()
    {
        ini_set('max_execution_time', 300); // 5 menit
        $synced = 0;
        $skipped = 0;

        $hcpmUsers = HcpmUser::all();

        foreach ($hcpmUsers as $hcpm) {
            // Cari user berdasarkan email
            $user = User::where('email', $hcpm->email)->first();

            if (!$user) {
                // Buat user baru
                $user = User::create([
                    'name' => $hcpm->name,
                    'email' => $hcpm->email,
                    'username' => $hcpm->username ?? null,
                    'department_id' => $hcpm->department_id ?? null,
                    'password' => bcrypt('12345678'),
                    'source' => 'synced user',
                ]);

                // Assign role default
                if ($user->email === 'puremachine99@gmail.com') {
                    $user->syncRoles(['super_admin']);
                } else {
                    $user->syncRoles(['smartnakama']);
                }

                $synced++;
            } else {
                $skipped++;
            }
        }

        return response()->json([
            'message' => 'Sync selesai',
            'synced_users' => $synced,
            'skipped_existing_users' => $skipped,
        ]);
    }
}
