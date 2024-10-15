<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SOTKModel;
use App\Services\ImageService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SOTKController extends Controller
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
                'nama' => 'required|string|max:255', // Nama harus diisi, string, dan tidak lebih dari 255 karakter
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Gambar harus berupa file image dengan tipe jpeg, png, atau jpg, dan ukuran maksimal 2MB
                'jabatan' => 'required|string|max:255' // Pastikan konten diisi dan tidak lebih dari 1000 karakter
            ]);



            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(), // Mengembalikan pesan kesalahan
                ], 400);
            }

            $upload = $this->imageService->uploadImage($request->file('image'));

            if ($upload['status'] === false) {
                throw new Exception($upload['message']);
            }

            SOTKModel::create([
                'nama' => $request->nama,
                'image' => $upload["path"],
                'jabatan' => $request->jabatan,
            ]);

            return response()->json([
                'message' => "SOTK Successfully create!",
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:1000',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 400);
        }
        try {
            $sotk = SOTKModel::findOrFail($id);

            if (!$sotk) {
                return response()->json([
                    'message' => "Id SOTK not available!",
                ], 200);
            }


            if ($request->file("image")) {
                $upload = $this->imageService->uploadImage($request->file("image"));
                $path = $upload['path'];

                $this->imageService->dropImage($sotk["image"]);

                $sotk->image = $path;
            }


            $sotk->nama =$request->nama;
            $sotk->jabatan = $request->jabatan;
            $sotk->save();

            return response()->json([
                'message' => "SOTK successfully update!",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function delete(Request $request) {
        try {
            $sotk = SOTKModel::findOrFail($request->id);
            if (!$sotk) {
                return response()->json([
                    'status' => false,
                    'error' => 'SOTK not faund!',
                ], 404);
            }


            $this->imageService->dropImage($sotk["image"]);

            $sotk->delete();
            return response()->json([
                'status' => true,
                'message' => 'SOTK sucessfully delete!',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function get(Request $request)
    {
        try {
            if ($request->id) {
                $sotk = SOTKModel::findOrFail($request->id);
                return response()->json([
                    'status' => true,
                    'news' => $sotk,
                ], 200);
            }

            $allSOTK = SOTKModel::all();
            return response()->json([
                'status' => true,
                'sotk' => $allSOTK,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

}
