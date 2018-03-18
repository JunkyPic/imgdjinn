<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginControllerPostLogin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * RegisterController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin() {
        return view('auth.login');
    }

    /**
     * @param LoginControllerPostLogin $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(LoginControllerPostLogin $request) {
        if (\Auth::attempt([
            'username' => $request->get('username'),
            'password' => $request->get('password')]))
        {
            return redirect()->route('home');
        }

        return redirect()->back();
    }
}
