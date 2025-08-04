<?php

namespace App\Http\Controllers;

use App\Models\HcpmUser;
use Illuminate\Http\Request;
use App\Models\User;

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
}
