<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PekerjaanModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PekerjaanController extends Controller
{
    //


    public function add(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'pekerjaan' => 'required|string|max:255', // Nama harus diisi, string, dan tidak lebih dari 255 karakter
                'jumlah' => 'required|numeric', // Gambar harus berupa file image dengan tipe jpeg, png, atau jpg, dan ukuran maksimal 2MB
            ]);


            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 400);
            }


            PekerjaanModel::create([
                'pekerjaan' => $request->pekerjaan,
                'jumlah' => $request->jumlah,
            ]);

            return response()->json([
                'message' => "Pekerjaan Successfully create!",
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
            'pekerjaan' => 'required|string|max:255', // Nama harus diisi, string, dan tidak lebih dari 255 karakter
            'jumlah' => 'required|numeric', // Gambar harus berupa file image dengan tipe jpeg, png, atau jpg, dan ukuran maksimal 2MB
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 400);
        }
        try {
            $pekerjaan = PekerjaanModel::find($id);

            if (!$pekerjaan) {
                return response()->json([
                    'message' => "Id Pekerjaan not available!",
                ], 404);
            }


            $pekerjaan->pekerjaan = $request->pekerjaan;
            $pekerjaan->jumlah = $request->jumlah;

            $pekerjaan->save();

            return response()->json([
                'message' => "Pekerjaan successfully update!",
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
            $work = PekerjaanModel::find($request->id);
            if (!$work) {
                return response()->json([
                    'status' => false,
                    'error' => 'Pekerjaan not faund!',
                ], 404);
            }


            $work->delete();
            return response()->json([
                'status' => true,
                'message' => 'Pekerjaan sucessfully delete!',
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
        if ($request->id) {
            $work = PekerjaanModel::find($request->id);
            if (!$work) {
                return response()->json([
                    'status' => true,
                    'error' => "Pekerjaan not found!",
                ], 404);
            }

            return response()->json([
                'status' => true,
                'Pekerjaan' => $work,
            ], 200);
        }
        try {

            $works = PekerjaanModel::all();
            return response()->json([
                'status' => true,
                'pekerjaan' => $works,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
