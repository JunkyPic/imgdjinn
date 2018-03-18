<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

/**
 * Class HomeController
 *
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    const PAGINATE = 12;

    public function home(Request $request) {
        $filters = $request->query->all();

        if(isset($filters['f_ord'])) {
            switch($filters['f_ord']){
                case 'nf':
                    $f_ord = 'DESC';
                    break;
                case 'of':
                    $f_ord = 'ASC';
                    break;
                default:
                    $f_ord = 'DESC';
                    break;
            }
        } else {
            $f_ord = 'DESC';
        }

        if(isset($filters['f_nsfw'])){
            switch($filters['f_nsfw']){
                case 'f_nsfw':
                    $nsfw = 0;
                    break;
                case 'mi':
                    $nsfw = 1;
                    break;
                case 'ns':
                    $only_nsfw = 1;
                    break;
                default:
                    $nsfw = 0;
                    break;
            }
        } else {
            $nsfw = 0;
            $only_nsfw = 0;
        }

        if(!isset($only_nsfw) && isset($nsfw) && $nsfw == 1) {
            $images = Image::where(['is_private' => 0])->whereIn('is_nsfw', [1, 0])->orderBy('created_at', $f_ord)->paginate(self::PAGINATE);

            return view('home')->with(['images' => $images]);
        }

        if(isset($only_nsfw) && $only_nsfw == 1) {
            $images = Image::where(['is_private' => 0, 'is_nsfw' => 1])->orderBy('created_at', $f_ord)->paginate(self::PAGINATE);

            return view('home')->with(['images' => $images]);
        }

        $images = Image::where(['is_private' => 0, 'is_nsfw' => 0])->orderBy('created_at', $f_ord)->paginate(self::PAGINATE);

        return view('home')->with(['images' => $images]);
    }
}
