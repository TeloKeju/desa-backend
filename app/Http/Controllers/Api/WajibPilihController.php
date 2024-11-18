<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WajibPilihModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WajibPilihController extends Controller
{

    public function get(Request $request)
    {
        if ($request->id) {
            $wajibPilih = WajibPilihModel::find($request->id);
            if (!$wajibPilih) {
                return response()->json([
                    'status' => true,
                    'error' => "wajib pilih not found!",
                ], 404);
            }

            return response()->json([
                'status' => true,
                'wajib_pilih' => $wajibPilih,
            ], 200);
        }
        try {

            $allWajibPilih = WajibPilihModel::all();
            return response()->json([
                'status' => true,
                'wajib_pilih' => $allWajibPilih,
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
                'id' => 'required|numeric|unique:wajib_pilih', // Nama harus diisi, string, dan tidak lebih dari 255 karakter
                'wajib_pilih' => 'required|numeric', // Gambar harus berupa file image dengan tipe jpeg, png, atau jpg, dan ukuran maksimal 2MB
            ]);


            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 400);
            }

            WajibPilihModel::create([
                'id' => $request->id,
                'wajib_pilih' => $request->wajib_pilih,
            ]);

            return response()->json([
                'message' => "wajib pilih Successfully create!",
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
            'id' => 'required|numeric', // Nama harus diisi, string, dan tidak lebih dari 255 karakter
            'wajib_pilih' => 'required|numeric', // Gambar harus berupa file image dengan tipe jpeg, png, atau jpg, dan ukuran maksimal 2MB
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 400);
        }
        try {
            $wajibPilih = WajibPilihModel::find($id);

            if (!$wajibPilih) {
                return response()->json([
                    'message' => "Id umur not available!",
                ], 404);
            }

            $wajibPilih->id = $request->id;
            $wajibPilih->wajib_pilih = $request->wajib_pilih;
            $wajibPilih->save();

            return response()->json([
                'message' => "wajib pilih successfully update!",
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
            $wajibPilih = WajibPilihModel::find($request->id);
            if (!$wajibPilih) {
                return response()->json([
                    'status' => false,
                    'error' => 'wajib_pilih not faund!',
                ], 404);
            }

            $wajibPilih->delete();
            return response()->json([
                'status' => true,
                'message' => 'wajib_pilih sucessfully delete!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
