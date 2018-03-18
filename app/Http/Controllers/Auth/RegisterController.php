<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegisterControllerRegisterPost;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'home';

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
    public function getRegister() {
        return view('auth.register');
    }

    /**
     * @param RegisterControllerRegisterPost $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister(RegisterControllerRegisterPost $request) {
        User::create([
           'username' => $request->get('username'),
           'password' => \Hash::make($request->get('password')),
           'alias' => Str::random(30) . substr(microtime(true), -4),
        ]);
        if (\Auth::attempt([
            'username' => $request->get('username'), 'password' => $request->get('password')])) {
            return redirect()->route('home');
        }

        return abort(520);
    }
}
