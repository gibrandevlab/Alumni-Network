<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomepageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('pages.welcome', [
            'id' => $user?->id ?? null,
            'role' => $user?->role ?? null,
            'status' => $user?->status ?? null,
        ]);
    }
}

