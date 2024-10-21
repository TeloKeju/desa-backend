<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UmurModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UmurController extends Controller
{

    public function get(Request $request)
    {
        if ($request->id) {
            $umur = UmurModel::find($request->id);
            if (!$umur) {
                return response()->json([
                    'status' => true,
                    'error' => "umur not found!",
                ], 404);
            }

            return response()->json([
                'status' => true,
                'umur' => $umur,
            ], 200);
        }
        try {

            $allUmur = UmurModel::all();
            return response()->json([
                'status' => true,
                'umur' => $allUmur,
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
            'umur' => 'required|string|max:255', // Nama harus diisi, string, dan tidak lebih dari 255 karakter
            'jumlah' => 'required|numeric', // Gambar harus berupa file image dengan tipe jpeg, png, atau jpg, dan ukuran maksimal 2MB
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 400);
        }
        try {
            $umur = UmurModel::find($id);

            if (!$umur) {
                return response()->json([
                    'message' => "Id umur not available!",
                ], 404);
            }

            $umur->umur = $request->umur;
            $umur->jumlah = $request->jumlah;
            $umur->save();

            return response()->json([
                'message' => "umur successfully update!",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
