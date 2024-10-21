<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PendidikanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PendidikanController extends Controller
{
    //


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pendidikan' => 'required|string|max:255', // Nama harus diisi, string, dan tidak lebih dari 255 karakter
            'jumlah' => 'required|numeric', // Gambar harus berupa file image dengan tipe jpeg, png, atau jpg, dan ukuran maksimal 2MB
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 400);
        }
        try {
            $pendidikan = PendidikanModel::find($id);

            if (!$pendidikan) {
                return response()->json([
                    'message' => "Id pendidikan not available!",
                ], 404);
            }


            $pendidikan->jenis_pendidikan = $request->pendidikan;
            $pendidikan->jumlah = $request->jumlah;

            $pendidikan->save();

            return response()->json([
                'message' => "pendidikan successfully update!",
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
        // return PendidikanModel::all();
        if ($request->id) {
            $pendidikan = PendidikanModel::find($request->id);
            if (!$pendidikan) {
                return response()->json([
                    'status' => true,
                    'error' => "pendidikan not found!",
                ], 404);
            }

            return response()->json([
                'status' => true,
                'pendidikan' => $pendidikan,
            ], 200);
        }
        try {

            $pendidikan = PendidikanModel::all();
            return response()->json([
                'status' => true,
                'pendidikan' => $pendidikan,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
