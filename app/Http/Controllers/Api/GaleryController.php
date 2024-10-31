<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GaleryModel;
use App\Services\ImageService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class GaleryController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public static function get(Request $request)
    {

        if ($request->id) {
            $galery = GaleryModel::find($request->id);

            if (!$galery) {
                return response()->json([
                    'status' => false,
                    'error' => "galery not found!",
                ], 404);
            }
            return response()->json([
                'status' => true,
                'galery' => $galery,
            ], 200);
        }

        try {

            $allGalery = GaleryModel::all();
            return response()->json([
                'status' => true,
                'galery' => $allGalery,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function add(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Pastikan judul diisi dan tidak lebih dari 255 karakter
            ]);


            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(), // Mengembalikan pesan kesalahan
                ], 400);
            }

            $upload = $this->imageService->uploadImage($request->file('image'), 'galery');

            if ($upload['status'] === false) {
                throw new Exception($upload['message']);
            }

            GaleryModel::create([
                'image' => $upload["path"],
            ]);

            return response()->json([
                'message' => "berhasil menambah galery!",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Pastikan judul diisi dan tidak lebih dari 255 karakter
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 400);
        }
        try {
            $galery = GaleryModel::find($id);

            if (!$galery) {
                return response()->json([
                    'message' => "Id Galery not available!",
                ], 404);
            }



            $upload = $this->imageService->uploadImage($request->file("image"), 'galery');
            $path = $upload['path'];

            $this->imageService->dropImage($galery["image"]);
            $galery->image = $path;


            $galery->save();

            return response()->json([
                'message' => "berhasil mengupdate galery!",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $galery = GaleryModel::find($request->id);
            if (!$galery) {
                return response()->json([
                    'status' => false,
                    'error' => 'News not faund!',
                ], 404);
            }

            $this->imageService->dropImage($galery["image"]);

            $galery->delete();
            return response()->json([
                'status' => true,
                'message' => 'News sucessfully delete!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
