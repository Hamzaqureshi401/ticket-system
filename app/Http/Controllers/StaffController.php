<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $staff = User::whereIn('role', ['admin', 'staff'])->get();
        return view('staff.index', compact('staff'));
    }
}