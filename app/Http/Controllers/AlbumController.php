<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

/**
 * Class UploadController
 *
 * @package App\Http\Controllers
 */
class AlbumController extends Controller
{
    /**
     * @param $alias
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($alias)
    {
        $album = Album::where(['alias' => $alias])->first();

        if(null === $album) {
            return abort(404);
        }

        // delete album if it has 0 images associated to it
        if(0 === (int)$album->images()->get()->count()) {
            $album->delete();
            return abort(404);
        }

        $display_token = false;

        if ((int)$album->display_token === 1) {
            $display_token = true;
        }

        $album->display_token = false;
        $album->save();

        return view('album')->with(['album' => $album, 'display_token' => $display_token]);
    }

    /**
     * @param         $alias
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($alias, Request $request)
    {
        if ( ! $request->request->has('optionsRadios')) {
            return redirect()->back()->with('error', 'Invalid token or password');
        }

        if ($request->request->has('token') && null !== $request->request->get('token')) {
            $album = Album::where(['alias' => $alias])->first();
            if ($album->token === $request->request->get('token')) {

                foreach ($album->images()->get() as $image) {
                    if (\File::exists(public_path('img/'.$image->path))) {
                        \File::delete(public_path('img/'.$image->path));
                    }
                }

                // get the images too
                $album->images()->delete();
                $album->delete();

                return redirect()->route('getUpload')->with(
                    ['album_delete_success' => 'Album and associated images deleted successfully']
                );
            }

            return redirect()->back()->with('error', 'Invalid token or password');
        }

        if ($request->request->has('password') && null !== $request->request->get('password')) {
            $album = Album::where(['alias' => $alias])->first();

            if (password_verify($request->request->get('password'), $album->password)) {

                foreach ($album->images()->get() as $image) {
                    if (\File::exists(public_path('img/'.$image->path))) {
                        \File::delete(public_path('img/'.$image->path));
                    }
                }

                // get the images too
                $album->images()->delete();
                $album->delete();

                return redirect()->route('getUpload')->with(
                    ['album_delete_success' => 'Album and associated images deleted successfully']
                );
            }

            return redirect()->back()->with('error', 'Invalid token or password');
        }

        return redirect()->back()->with('error', 'Invalid token or password');
    }
}
