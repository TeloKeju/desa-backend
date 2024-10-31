<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UmkmModel;
use App\Services\ImageService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UmkmController extends Controller
{
    //
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function add(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255', // Nama harus diisi, string, dan tidak lebih dari 255 karakter
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Gambar harus berupa file image dengan tipe jpeg, png, atau jpg, dan ukuran maksimal 2MB
                'description' => 'required|string|max:255', // Pastikan konten diisi dan tidak lebih dari 1000 karakter
                'contact' => 'required|string|max:255',  // Pastikan konten diisi dan tidak lebih dari 1000 karakter
                'price' => 'required|max:255',  // Pastikan konten diisi dan tidak lebih dari 1000 karakter
            ]);


            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 400);
            }

            $upload = $this->imageService->uploadImage($request->file('image'), 'UMKM');

            if ($upload['status'] === false) {
                throw new Exception($upload['message']);
            }

            UmkmModel::create([
                'name' => $request->name,
                'image' => $upload["path"],
                'description' => $request->description,
                'contact' => $request->contact,
                'price' => $request->price,
            ]);

            return response()->json([
                'message' => "UMKM Successfully create!",
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
            'name' => 'required|string|max:255', // Nama harus diisi, string, dan tidak lebih dari 255 karakter
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Gambar harus berupa file image dengan tipe jpeg, png, atau jpg, dan ukuran maksimal 2MB
            'description' => 'required|string|max:255', // Pastikan konten diisi dan tidak lebih dari 1000 karakter
            'contact' => 'required|string|max:255',  // Pastikan konten diisi dan tidak lebih dari 1000 karakter
            'price' => 'required|max:255',  // Pastikan konten diisi dan tidak lebih dari 1000 karakter
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 400);
        }
        try {
            $umkm = UmkmModel::find($id);

            if (!$umkm) {
                return response()->json([
                    'message' => "Id umkm not available!",
                ], 404);
            }


            if ($request->file("image")) {
                $upload = $this->imageService->uploadImage($request->file("image"), 'UMKM');
                $path = $upload['path'];

                $this->imageService->dropImage($umkm["image"]);

                $umkm->image = $path;
            }


            $umkm->name = $request->name;
            $umkm->description = $request->description;
            $umkm->contact = $request->contact;
            $umkm->price = $request->price;
            $umkm->save();

            return response()->json([
                'message' => "umkm successfully update!",
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
            $umkm = UmkmModel::find($request->id);
            if (!$umkm) {
                return response()->json([
                    'status' => false,
                    'error' => 'umkm not faund!',
                ], 404);
            }


            $this->imageService->dropImage($umkm["image"]);

            $umkm->delete();
            return response()->json([
                'status' => true,
                'message' => 'umkm sucessfully delete!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function get(Request $request)
    {
        if ($request->id) {
            $umkm = UmkmModel::find($request->id);
            if (!$umkm) {
                return response()->json([
                    'status' => true,
                    'error' => "umkm not found!",
                ], 404);
            }

            return response()->json([
                'status' => true,
                'umkm' => $umkm,
            ], 200);
        }
        try {

            $allUMKM = UmkmModel::all();
            return response()->json([
                'status' => true,
                'umkm' => $allUMKM,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
