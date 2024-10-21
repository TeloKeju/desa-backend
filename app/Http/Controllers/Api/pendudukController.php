<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\pendudukModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class pendudukController extends Controller
{
    //
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'total_penduduk' => 'required|numeric', // Nama harus diisi, string, dan tidak lebih dari 255 karakter
            'kepala_keluarga' => 'required|numeric', // Nama harus diisi, string, dan tidak lebih dari 255 karakter
            'perempuan' => 'required|numeric', // Gambar harus berupa file image dengan tipe jpeg, png, atau jpg, dan ukuran maksimal 2MB
            'laki_laki' => 'required|numeric', // Gambar harus berupa file image dengan tipe jpeg, png, atau jpg, dan ukuran maksimal 2MB
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 400);
        }
        try {
            $penduduk = pendudukModel::find($id);

            if (!$penduduk) {
                return response()->json([
                    'message' => "Id penduduk not available!",
                ], 404);
            }


            $penduduk->total_penduduk = $request->total_penduduk;
            $penduduk->kepala_keluarga = $request->kepala_keluarga;
            $penduduk->perempuan = $request->perempuan;
            $penduduk->laki_laki = $request->laki_laki;

            $penduduk->save();

            return response()->json([
                'message' => "penduduk successfully update!",
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
        // return pendudukModel::all();
        try {
            $penduduk = pendudukModel::find(1);
            return response()->json([
                'status' => true,
                'penduduk' => $penduduk,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
