<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        return redirect()->route(match ((int) $user->role_id) {
            1 => 'depart.home',
            2 => 'mitra.home',
            3 => 'dospem.home',
            4 => 'supervisor.home',
            5 => 'mahasiswa.home',
            6 => 'superadmin.home',
            default => 'login',
        });
    }
}
