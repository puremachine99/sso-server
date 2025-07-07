<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return response()->json([
        'id' => $request->user()->id, // digunakan untuk smartid_id
        'name' => $request->user()->name,
        'email' => $request->user()->email,
        'linked_accounts' => $request->user()->linked_accounts ?? [],
    ]);
});