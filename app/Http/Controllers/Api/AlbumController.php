<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AlbumResource;
use App\Models\Album;
use App\Http\Controllers\Controller;

class AlbumController extends Controller
{
    public function apiGetAlbum($alias) {
        AlbumResource::withoutWrapping();
        return new AlbumResource(Album::where(['alias' => $alias])->select(['alias', 'token'])->first());
    }
}
