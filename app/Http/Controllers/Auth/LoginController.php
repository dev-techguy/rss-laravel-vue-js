<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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

    /**
     * admin login page
     *
     * @return Renderable
     */
    public function adminLoginPage()
    {
        return view('auth.admin.login');
    }

    /**
     * login the admin
     * @throws ValidationException
     */
    public function adminLogin()
    {
        //validate incoming request
        $this->validate(request(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = request()->only(['email', 'password']);

        if (!Auth::guard('admin')->attempt($credentials)) {
            return redirect()->back()->withErrors('Wrong credentials');
        }

        return redirect()->route('admin.home');
    }
}
