<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\agamaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class agamaController extends Controller
{


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'agama' => 'required|string|max:255', // Nama harus diisi, string, dan tidak lebih dari 255 karakter
            'jumlah' => 'required|numeric', // Gambar harus berupa file image dengan tipe jpeg, png, atau jpg, dan ukuran maksimal 2MB
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 400);
        }
        try {
            $agama = agamaModel::find($id);

            if (!$agama) {
                return response()->json([
                    'message' => "Id agama not available!",
                ], 404);
            }


            $agama->nama_agama = $request->agama;
            $agama->jumlah_penganut = $request->jumlah;

            $agama->save();

            return response()->json([
                'message' => "agama successfully update!",
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
        // return agamaModel::all();
        if ($request->id) {
            $agama = agamaModel::find($request->id);
            if (!$agama) {
                return response()->json([
                    'status' => true,
                    'error' => "agama not found!",
                ], 404);
            }

            return response()->json([
                'status' => true,
                'agama' => $agama,
            ], 200);
        }
        try {

            $agama = agamaModel::all();
            return response()->json([
                'status' => true,
                'agama' => $agama,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
