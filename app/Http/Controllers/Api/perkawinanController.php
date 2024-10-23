<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\perkawinanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class perkawinanController extends Controller
{

    public function get(Request $request)
    {
        if ($request->id) {
            $kawin = perkawinanModel::find($request->id);
            if (!$kawin) {
                return response()->json([
                    'status' => true,
                    'error' => "wajib pilih not found!",
                ], 404);
            }

            return response()->json([
                'status' => true,
                'wajib_pilih' => $kawin,
            ], 200);
        }
        try {

            $allKawin = perkawinanModel::all();
            return response()->json([
                'status' => true,
                'umur' => $allKawin,
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
            'id' => 'required|numeric|unique:wajib_pilih', // Nama harus diisi, string, dan tidak lebih dari 255 karakter
            'wajib_pilih' => 'required|numeric', // Gambar harus berupa file image dengan tipe jpeg, png, atau jpg, dan ukuran maksimal 2MB
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 400);
        }

        try {
            $kawin = perkawinanModel::find($id);

            if (!$kawin) {
                return response()->json([
                    'message' => "Id perkawinan not available!",
                ], 404);
            }

            $kawin->id = $request->id;
            $kawin->belum_kawin = $request->belum_kawin;
            $kawin->kawin = $request->kawin;
            $kawin->cerai_mati = $request->cerai_mati;
            $kawin->cerai_hidup = $request->cerai_hidup;
            $kawin->save();

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
}
