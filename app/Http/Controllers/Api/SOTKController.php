<?php

namespace App\Http\Controllers;

use App\Models\SOTKModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ImageService;

class SOTKController extends Controller
{

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
                'title' => $request->nama,
                'image' => $upload["path"],
                'content' => $request->content,
            ]);
            return response()->json([
                'message' => "berhasil menambah news!",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function update(Request $request) {}
    public function delete(Request $request) {}
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
