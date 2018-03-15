<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getLogout() {
        if (\Auth::check()) {
            \Auth::logout();
        }

        return redirect()->route('getUpload');
    }
}
