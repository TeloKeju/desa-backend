<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\apbModel;
use Illuminate\Support\Facades\Validator;

class apbController extends Controller
{

    public function get(Request $request)
    {
        if ($request->id) {
            $apb = apbModel::find($request->id);
            if (!$apb) {
                return response()->json([
                    'status' => true,
                    'error' => "wajib pilih not found!1",
                ], 404);
            }

            return response()->json([
                'status' => true,
                'apb' => $apb,
            ], 200);
        }
        try {

            $allapb = apbModel::all();
            return response()->json([
                'status' => true,
                'apb' => $allapb,
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
                'tahun' => 'required|numeric|unique:apb', // Nama harus diisi, string, dan tidak lebih dari 255 karakter
                'pendapatan' => 'required|numeric', // Gambar harus berupa file image dengan tipe jpeg, png, atau jpg, dan ukuran maksimal 2MB
                'belanja' => 'required|numeric', // Gambar harus berupa file image dengan tipe jpeg, png, atau jpg, dan ukuran maksimal 2MB
                'penerimaan' => 'required|numeric', // Gambar harus berupa file image dengan tipe jpeg, png, atau jpg, dan ukuran maksimal 2MB
                'pengeluaran' => 'required|numeric', // Gambar harus berupa file image dengan tipe jpeg, png, atau jpg, dan ukuran maksimal 2MB
            ]);


            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 400);
            }

            apbModel::create([
                'tahun' => $request->tahun,
                'pendapatan' => $request->pendapatan,
                'belanja' => $request->belanja,
                'penerimaan' => $request->penerimaan,
                'pengeluaran' => $request->pengeluaran,
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
            'tahun' => 'required|numeric', // Nama harus diisi, string, dan tidak lebih dari 255 karakter
            'pendapatan' => 'required|numeric', // Gambar harus berupa file image dengan tipe jpeg, png, atau jpg, dan ukuran maksimal 2MB
            'belanja' => 'required|numeric', // Gambar harus berupa file image dengan tipe jpeg, png, atau jpg, dan ukuran maksimal 2MB
            'penerimaan' => 'required|numeric', // Gambar harus berupa file image dengan tipe jpeg, png, atau jpg, dan ukuran maksimal 2MB
            'pengeluaran' => 'required|numeric', // Gambar harus berupa file image dengan tipe jpeg, png, atau jpg, dan ukuran maksimal 2MB
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 400);
        }
        try {
            // return $tahun = [/tahun => $tahun];
            $apb = apbModel::find($id);

            if (!$apb) {
                return response()->json([
                    'message' => "Id apb not available!",
                ], 404);
            }

            $apb->tahun = $request->tahun;
            $apb->pendapatan = $request->pendapatan;
            $apb->belanja = $request->belanja;
            $apb->penerimaan = $request->penerimaan;
            $apb->pengeluaran = $request->pengeluaran;
            $apb->save();

            return response()->json([
                'message' => "apb successfully update!",
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
            $apb = apbModel::find($request->id);
            if (!$apb) {
                return response()->json([
                    'status' => false,
                    'error' => 'apb not faund!',
                ], 404);
            }

            $apb->delete();
            return response()->json([
                'status' => true,
                'message' => 'apb sucessfully delete!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
