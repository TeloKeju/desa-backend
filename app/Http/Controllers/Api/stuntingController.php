<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\stuntingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class stuntingController extends Controller
{
    //

    public function get(Request $request)
    {
        if ($request->id) {
            $stunting = stuntingModel::find($request->id);
            if (!$stunting) {
                return response()->json([
                    'status' => true,
                    'error' => "stunting not found!",
                ], 404);
            }

            return response()->json([
                'status' => true,
                'stunting' => $stunting,
            ], 200);
        }
        try {

            $allStunting = stuntingModel::all();
            return response()->json([
                'status' => true,
                'stunting' => $allStunting,
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
                'tahun' => 'required|numeric|unique:stunting', // Nama harus diisi, string, dan tidak lebih dari 255 karakter
                "jumlah" => "required|numeric"
            ]);


            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 400);
            }

            stuntingModel::create([
                'tahun' => $request->tahun,
                "jumlah" => $request->jumlah
            ]);

            return response()->json([
                'message' => "stunting Successfully create!",
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
            'tahun' => 'required|numeric',
            "jumlah" => 'required|numeric'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 400);
        }
        try {
            // return $tahun = [/tahun => $tahun];
            $Stunting = stuntingModel::find($id);

            if (!$Stunting) {
                return response()->json([
                    'message' => "Id Stunting not available!",
                ], 404);
            }

            $Stunting->tahun = $request->tahun;
            $Stunting->jumlah = $request->jumlah;

            $Stunting->save();

            return response()->json([
                'message' => "Stunting successfully update!",
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
            $stunting = stuntingModel::find($request->id);
            if (!$stunting) {
                return response()->json([
                    'status' => false,
                    'error' => 'stunting not faund!',
                ], 404);
            }

            $stunting->delete();
            return response()->json([
                'status' => true,
                'message' => 'stunting sucessfully delete!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
