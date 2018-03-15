<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileControllerChangePasswordPost;

/**
 * Class ProfileController
 *
 * @package App\Http\Controllers
 */
class ProfileController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getProfile() {
        return view('user.profile');
    }

    /**
     * @param ProfileControllerChangePasswordPost $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(ProfileControllerChangePasswordPost $request) {
        $user = \Auth::user();

        if($user) {
            $user->password = \Hash::make($request->get('password'));
            $user->save();
            return redirect()->back()->with(['success' => 'Password changed successfully']);
        }

        return redirect()->back()->with(['error' => 'Unable to change password']);
    }
}
