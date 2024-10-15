<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GaleryModel;
use App\Services\ImageService;
use Exception;
use Illuminate\Http\Request;


class GaleryController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public static function get(Request $request){
        try {
            if ($request->id) {
                $news = GaleryModel::findOrFail($request->id);
                return response()->json([
                    'status' => true,
                    'news' => $news,
                ], 200);
            }

            $allNews = GaleryModel::all();
            return response()->json([
                'status' => true,
                'news' => $allNews,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function add(Request $request){

    }

}
