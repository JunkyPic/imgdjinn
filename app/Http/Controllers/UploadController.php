<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadControllerRequestPost;
use App\Models\Album;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use App\Models\Image as ImageModel;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Class UploadController
 *
 * @package App\Http\Controllers
 */
class UploadController extends Controller
{
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
                    $imageName = Str::random(10) . '.webm';
                    $process = new Process('/usr/bin/ffmpeg -i ' . $image->getRealPath() . ' ' . rtrim(\Config::get('image.path.upload'), '/') . DIRECTORY_SEPARATOR . $imageName);
                    try {
                        $process->mustRun();
                    } catch (ProcessFailedException $exception) {
                        // well that sucks, it failed for some reason
                        copy($image->getRealPath(), \Config::get('image.path.upload') . $imageName);
                    }
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
                        'is_nsfw' => $request->request->has('nsfw') ? true : false,
                        'is_private' => $request->request->has('private') ? true : false,
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
                $imageName = Str::random(10) . '.webm';
                $process = new Process('/usr/bin/ffmpeg -i ' . $image->getRealPath() . ' ' . rtrim(\Config::get('image.path.upload'), '/') . DIRECTORY_SEPARATOR . $imageName);
                try {
                    $process->mustRun();
                } catch (ProcessFailedException $exception) {
                    // well that sucks, it failed for some reason
                    copy($image->getRealPath(), \Config::get('image.path.upload') . $imageName);
                }
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
                    'is_nsfw' => $request->request->has('nsfw') ? true : false,
                    'is_private' => $request->request->has('private') ? true : false,
                ]
            );
        }

        return redirect()->route('showImage', ['alias' => $imageDb->alias]);
    }
}
