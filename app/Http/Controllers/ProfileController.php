<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show profile for currently authenticated user (general user view)
     */
    public function show()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * Show profile for admin (admin view)
     */
    public function adminShow()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }
}
