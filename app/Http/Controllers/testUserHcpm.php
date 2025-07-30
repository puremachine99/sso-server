<?php

namespace App\Http\Controllers;

use App\Models\HcpmUser;
use Illuminate\Http\Request;

class testUserHcpm extends Controller
{
    public function index()
    {
        $users = HcpmUser::with('jobTitles')->get(); // relasi jobTitles penting
        return view('test.hcpm-users', compact('users'));
    }
    public function show($id)
    {
        $user = HcpmUser::with([
            'JobTitle',
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
}
