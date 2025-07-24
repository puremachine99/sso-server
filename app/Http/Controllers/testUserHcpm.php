<?php

namespace App\Http\Controllers;

use App\Models\HcpmUser;
use Illuminate\Http\Request;

class testUserHcpm extends Controller
{
    public function index()
    {
        $users = HcpmUser::all(); // Tarik semua user dari DB HCPM
        return view('test.hcpm-users', compact('users'));
    }
}
