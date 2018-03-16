<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageControllerDeleteImagePost;
use App\Models\Album;
use App\Models\Image;
use Illuminate\Http\Request;

/**
 * Class ImageController
 *
 * @package App\Http\Controllers
 */
class ImageController extends Controller
{
    /**
     * @param                                $imageAlias
     * @param ImageControllerDeleteImagePost $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userPostImageDelete($imageAlias, ImageControllerDeleteImagePost $request) {
        $image = Image::where(['alias' => $imageAlias])->first();

        if(null === $image) {
            return redirect()->back()->with('error', 'Image not found');
        }

        if($image->user_id != \Auth::user()->id) {
            return redirect()->back()->with('error', 'Image not associated with current user');
        }

        // Check for album too
        if(null !== $image->album_id) {
            // Get the album and count total photos in it
            $album = Album::where(['id' => $image->album_id])->with('images')->first();
        }

        if(\File::exists(\Config::get('image.path.upload') . $image->path)) {
            if(isset($album) && $album->images()->count() == 1) {
                // remove the album too since this is the last image
                $album->delete();
            }

            $image->delete();
            \File::delete(\Config::get('image.path.upload') . $image->path);

            return redirect()->back()->with('success', 'Image successfully deleted');
        }

        return redirect()->back()->with('error', 'Something went wrong. Not sure what tho...Try again later maybe?');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getImagesUser() {
        $images = Image::where(['user_id' => \Auth::user()->id])->orderBy('created_at', 'desc')->paginate(6);
        return view('user.images')->with(['images' => $images]);
    }

    /**
     * @param $alias
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($alias)
    {
        $image = Image::where(['alias' => $alias])->first();

        if(null === $image) {
            return abort(404);
        }

        $display_token = false;

        if ((int)$image->display_token === 1) {
            $display_token = true;
        }

        $image->display_token = false;
        $image->save();

        return view('image')->with(['image' => $image, 'display_token' => $display_token]);
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
            $image = Image::where(['alias' => $alias])->first();
            if ($image->token === $request->request->get('token')) {

                if (\File::exists(\Config::get('image.path.upload') . $image->path)) {
                    \File::delete(\Config::get('image.path.upload') . $image->path);
                }

                $image->delete();

                return redirect()->route('getUpload')->with(
                    ['image_delete_success' => 'Image deleted successfully']
                );
            }

            return redirect()->back()->with('error', 'Invalid token or password');
        }

        if ($request->request->has('password') && null !== $request->request->get('password')) {
            $image = Image::where(['alias' => $alias])->first();

            if (\Hash::check($request->request->get('password'), $image->password)) {

                if (\File::exists(\Config::get('image.path.upload') . $image->path)) {
                    \File::delete(\Config::get('image.path.upload') . $image->path);
                }

                // get the images too
                $image->delete();

                return redirect()->route('getUpload')->with(
                    ['image_delete_success' => 'Image deleted successfully']
                );
            }

            return redirect()->back()->with('error', 'Invalid token or password');
        }

        return redirect()->back()->with('error', 'Invalid token or password');
    }
}
