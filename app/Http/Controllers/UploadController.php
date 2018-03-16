<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadControllerRequestPost;
use App\Models\Album;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use App\Models\Image as ImageModel;

/**
 * Class UploadController
 *
 * @package App\Http\Controllers
 */
class UploadController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpload()
    {
        return view('upload');
    }

    /**
     * @param UploadControllerRequestPost $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postUpload(UploadControllerRequestPost $request)
    {
        $images = $request->file('img');
        $userId = \Auth::check() ? \Auth::user()->id : null;

        if (count($images) > 1) {
            // create an album
            $albumAlias = Str::random(10);
            $albumToken = null;
            $albumPassword = null;

            if ($request->request->has('optionsRadios') && $request->request->get('optionsRadios') == 'token') {
                $albumToken = Str::random(40) . substr(str_replace('.', '', microtime(true)), -6);
            }

            if ($request->request->has('optionsRadios') && $request->request->get('optionsRadios') == 'password') {
                $albumPassword = $request->request->get('password');
            }

            $album = Album::create(
                [
                    'alias'         => $albumAlias,
                    'password'      => isset($albumPassword) ? \Hash::make($albumPassword) : null,
                    'token'         => isset($albumToken) ? $albumToken : null,
                    'display_token' => isset($albumToken) ? true : false,
                    'user_id' => $userId,
                ]
            );

            $imagesToAlbum = [];

            foreach ($images as $image) {
                $imageName = Str::random(10) . '.' . $image->getClientOriginalExtension();
                $imageAlias = Str::random(10);

                $img = Image::make($image->getRealPath());

                if ($image->getClientOriginalExtension() == 'gif') {
                    copy($image->getRealPath(), \Config::get('image.path.upload') . $imageName);
                }else {
                    $img->save(\Config::get('image.path.upload') . $imageName, 70);
                }
                $img->destroy();

                $imageDb = ImageModel::create(
                    [
                        'path'          => $imageName,
                        'alias'         => $imageAlias,
                        'password'      => isset($albumPassword) ? \Hash::make($albumPassword) : null,
                        'token'         => isset($albumToken) ? $albumToken : null,
                        'display_token' => false,
                        'user_id' => $userId,
                    ]
                );

                $imagesToAlbum[] = $imageDb;
            }

            $album->images()->saveMany($imagesToAlbum);

            return redirect()->route('showAlbum', ['id' => $album->alias]);
        }

        foreach ($images as $image) {
            $imageName = Str::random(10).'.'.$image->getClientOriginalExtension();
            $imageAlias = Str::random(10);;

            $img = Image::make($image->getRealPath());

            if ($image->getClientOriginalExtension() == 'gif') {
                copy($image->getRealPath(), \Config::get('image.path.upload') . $imageName);
            }else {
                $img->save(\Config::get('image.path.upload') . $imageName, 70);
            }
            $img->destroy();

            $imageToken = null;
            $imagePassword = null;

            if ($request->request->has('optionsRadios') && $request->request->get('optionsRadios') == 'token') {
                $imageToken = Str::random(40).substr(
                        str_replace('.', '', microtime(true)),
                        -6
                    );
            }

            if ($request->request->has('optionsRadios') && $request->request->get('optionsRadios') == 'password') {
                $imagePassword = $request->request->get('password');
            }

            $imageDb = ImageModel::create(
                [
                    'path'          => $imageName,
                    'alias'         => $imageAlias,
                    'password'      => isset($imagePassword) ? \Hash::make($imagePassword) : null,
                    'token'         => isset($imageToken) ? $imageToken : null,
                    'display_token' => isset($imageToken) ? true : false,
                    'user_id' => $userId,
                ]
            );
        }

        return redirect()->route('showImage', ['alias' => $imageDb->alias]);
    }
}
