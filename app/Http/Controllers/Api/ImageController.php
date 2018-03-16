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

      $image = Image::where(['alias' => $alias])->select('path')->first();

      return new JsonResponse($image->path, 200, ['Access-Control-Allow-Origin' => '*']);

//        return new ImageResource();
    }

    public function apiGetAlbumImages($alias) {
        ImageResource::withoutWrapping();

        $album = Album::where(['alias' => $alias])->first();

        $data = [];
        foreach($album->images()->get() as $item) {
          $data[] = $item->path;
        }

        return new JsonResponse($data, 200, ['Access-Control-Allow-Origin' => '*']);

        return new ImagesResource($album->images()->get());
    }
}
