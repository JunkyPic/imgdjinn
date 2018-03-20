<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlbumControllerDeleteAlbumPost;
use App\Models\Album;
use Illuminate\Http\Request;

/**
 * Class UploadController
 *
 * @package App\Http\Controllers
 */
class AlbumController extends Controller
{

    public function userPostAlbumDelete(Request $request){
        $albums = Album::whereIn('alias', ($request->request->get('aliases')))->with('images')->get();

        if(null === $albums) {
            return [
                'error' => 'Record not found',
            ];
        }

        $userId = \Auth::user()->id;
        $albumAliases = [];

        foreach($albums as $album) {
            if($album->user_id != $userId) {
                return [
                    'error' => 'Image not associated with current user',
                ];
            }

            $albumAliases[] = $album->alias;
        }

        foreach ($albums as $item) {
            foreach($item->images()->get() as $image) {
                if(\File::exists(\Config::get('image.path.upload') . $image->path)) {
                    $image->delete();
                    \File::delete(\Config::get('image.path.upload') . $image->path);
                }
            }
            $item->delete();
        }
        return [
            'success' => true,
            'ids' => $albumAliases,
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAlbumsUser() {
        $albums = Album::where(['user_id' => \Auth::user()->id])->orderBy('created_at', 'desc')->paginate(12);
        return view('user.albums')->with(['albums' => $albums]);
    }

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
                    if (\File::exists(\Config::get('image.path.upload') . $image->path)) {
                        \File::delete(\Config::get('image.path.upload') . $image->path);
                    }
                }

                // get the images too
                $album->images()->delete();
                $album->delete();

                return redirect()->route('home')->with(
                    ['album_delete_success' => 'Album and associated images deleted successfully']
                );
            }

            return redirect()->back()->with('error', 'Invalid token or password');
        }

        if ($request->request->has('password') && null !== $request->request->get('password')) {
            $album = Album::where(['alias' => $alias])->first();

            if (\Hash::check($request->request->get('password'), $album->password)) {

                foreach ($album->images()->get() as $image) {
                    if (\File::exists(\Config::get('image.path.upload') . $image->path)) {
                        \File::delete(\Config::get('image.path.upload') . $image->path);
                    }
                }

                // get the images too
                $album->images()->delete();
                $album->delete();

                return redirect()->route('home')->with(
                    ['album_delete_success' => 'Album and associated images deleted successfully']
                );
            }

            return redirect()->back()->with('error', 'Invalid token or password');
        }

        return redirect()->back()->with('error', 'Invalid token or password');
    }
}
