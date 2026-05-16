<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
        public function index()
    {
        if (Auth::user()->role_id === 2 || Auth::user()->role_id === 3) {
             return Auth::user()->role_id === 2
            ? app(\App\Http\Controllers\OwnerCourseController::class)->index()
            : app(\App\Http\Controllers\CustomerCourseController::class)->index();
        }else {
            app(\App\Http\Controllers\AdminController::class)->index();
        }
    }
}
