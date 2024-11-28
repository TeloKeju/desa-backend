<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\bansosModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class bansosController extends Controller
{
    //
    public function update(Request $request, $id)
    {
        // return $request->bantuanCaleg;
        $validator = Validator::make($request->all(), [
            "vaksin1" => "required|numeric",
            "vaksin2" => "required|numeric",
            "bnpt" => "required|numeric",
            "blt" => "required|numeric",
            "pkh" => "required|numeric",
            "bst" => "required|numeric",
            "bantuanCaleg" => "required|numeric",
            "baznas" => "required|numeric",
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 400);
        }
        try {
            $bansos = bansosModel::find($id);
            if (!$bansos) {
                return response()->json([
                    'message' => "Id bansos not available!",
                ], 404);
            }

            $bansos->vaksin1 = $request->vaksin1;
            $bansos->vaksin2 = $request->vaksin2;
            $bansos->bnpt = $request->bnpt;
            $bansos->blt = $request->blt;
            $bansos->pkh = $request->pkh;
            $bansos->bst = $request->bst;
            $bansos->bantuanCaleg = $request->bantuanCaleg;
            $bansos->baznas = $request->baznas;

            $bansos->save();

            return response()->json([
                'message' => "Bansos successfully update!",
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
            $bansos = bansosModel::find($request->id);
            if (!$bansos) {
                return response()->json([
                    'status' => true,
                    'error' => "Bansos not found!",
                ], 404);
            }

            return response()->json([
                'status' => true,
                'bansos' => $bansos,
            ], 200);
        }
        try {

            $bansos = bansosModel::all();
            return response()->json([
                'status' => true,
                'Bansos' => $bansos,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
