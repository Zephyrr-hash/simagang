<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('errorForm', $validator->errors()->getMessages())
                ->withInput();
        }

        $credentials = request(['email', 'password']);
        if (Auth::attempt($credentials)) {
            // Regenerate session untuk mencegah session fixation & 419 PAGE EXPIRED
            $request->session()->regenerate();

            $user = $request->user();
            if ($user->role_id == Role::DEPARTEMEN) {
                return redirect()->route('depart.home');
            } elseif ($user->role_id == Role::MITRA) {
                return redirect()->route('mitra.home');
            } elseif ($user->role_id == Role::DOSPEM) {
                return redirect()->route('dospem.home');
            } elseif ($user->role_id == Role::SUPERVISOR) {
                return redirect()->route('supervisor.home');
            } elseif ($user->role_id == Role::MAHASISWA) {
                return redirect()->route('mahasiswa.home');
            }
        }
        return back()->with('error', 'Alamat email dan password tidak sesuai!');
        
    }
}
