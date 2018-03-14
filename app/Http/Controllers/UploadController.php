<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadControllerRequestPost;
use App\Models\Album;
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

        if (count($images) > 1) {
            // create an album
            $albumAlias = bin2hex(openssl_random_pseudo_bytes(5)).substr(str_replace('.', '', microtime(true)), -6);
            $albumToken = null;
            $albumPassword = null;

            if ($request->request->has('optionsRadios') && $request->request->get('optionsRadios') == 'token') {
                $albumToken = bin2hex(openssl_random_pseudo_bytes(20)).substr(
                        str_replace('.', '', microtime(true)),
                        -6
                    );
            }

            if ($request->request->has('optionsRadios') && $request->request->get('optionsRadios') == 'password') {
                $albumPassword = $request->request->get('password');
            }

            $album = Album::create(
                [
                    'alias'         => $albumAlias,
                    'password'      => isset($albumPassword) ? password_hash(
                        $albumPassword,
                        PASSWORD_DEFAULT
                    ) : null,
                    'token'         => isset($albumToken) ? $albumToken : null,
                    'display_token' => isset($albumToken) ? true : false,
                ]
            );

            $imagesToAlbum = [];

            foreach ($images as $image) {
                $imageName = bin2hex(openssl_random_pseudo_bytes(20)).substr(
                        str_replace('.', '', microtime(true)),
                        -6
                    ).'.'.$image->getClientOriginalExtension();
                $imageAlias = bin2hex(openssl_random_pseudo_bytes(5)).substr(str_replace('.', '', microtime(true)), -6);

                $img = Image::make($image->getRealPath());

                if ($image->getClientOriginalExtension() == 'gif') {
                    copy($image->getRealPath(), public_path('img/'.$imageName));
                }else {
                    $img->save(public_path('img/'.$imageName), 70);
                }
                $img->destroy();

                $imageDb = ImageModel::create(
                    [
                        'path'          => $imageName,
                        'alias'         => $imageAlias,
                        'password'      => isset($albumPassword) ? password_hash(
                            $albumPassword,
                            PASSWORD_DEFAULT
                        ) : null,
                        'token'         => isset($albumToken) ? $albumToken : null,
                        'display_token' => false,
                    ]
                );

                $imagesToAlbum[] = $imageDb;
            }

            $album->images()->saveMany($imagesToAlbum);

            return redirect()->route('showAlbum', ['id' => $album->alias]);
        }

        foreach ($images as $image) {
            $imageName = bin2hex(openssl_random_pseudo_bytes(20)).substr(
                    str_replace('.', '', microtime(true)),
                    -6
                ).'.'.$image->getClientOriginalExtension();
            $imageAlias = bin2hex(openssl_random_pseudo_bytes(5)).substr(str_replace('.', '', microtime(true)), -6);

            $img = Image::make($image->getRealPath());

            if ($image->getClientOriginalExtension() == 'gif') {
                copy($image->getRealPath(), public_path('img/'.$imageName));
            }else {
                $img->save(public_path('img/'.$imageName), 70);
            }
            $img->destroy();

            $imageToken = null;
            $imagePassword = null;

            if ($request->request->has('optionsRadios') && $request->request->get('optionsRadios') == 'token') {
                $imageToken = bin2hex(openssl_random_pseudo_bytes(20)).substr(
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
                    'password'      => isset($imagePassword) ? password_hash(
                        $imagePassword,
                        PASSWORD_DEFAULT
                    ) : null,
                    'token'         => isset($imageToken) ? $imageToken : null,
                    'display_token' => isset($imageToken) ? true : false,
                ]
            );
        }

        return redirect()->route('showImage', ['alias' => $imageDb->alias]);
    }
}
