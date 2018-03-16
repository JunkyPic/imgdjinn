<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ImageResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\ImagesResource;
use App\Models\Album;
use App\Models\Image;
use Illuminate\Http\JsonResponse;

/**
 * Class ImageController
 *
 * @package App\Http\Controllers\Api
 */
class ImageController extends Controller
{

  /**
   * @param $alias
   *
   * @return \Illuminate\Http\JsonResponse
   */
    public function apiGetImage($alias) {
        ImageResource::withoutWrapping();

        return (new ImageResource(Image::where(['alias' => $alias])->select('path')->first()))
          ->response()
          ->header('Access-Control-Allow-Origin', '*');
    }

    public function apiGetAlbumImages($alias) {
        ImageResource::withoutWrapping();

        $album = Album::where(['alias' => $alias])->first();

        return (new ImagesResource($album->images()->get()))
          ->response()
          ->header('Access-Control-Allow-Origin', '*');
    }
}
