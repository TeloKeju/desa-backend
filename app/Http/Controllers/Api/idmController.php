<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\idmModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class idmController extends Controller
{
    //

    public function get(Request $request)
    {
        if ($request->id) {
            $idm = idmModel::find($request->id);
            if (!$idm) {
                return response()->json([
                    'status' => true,
                    'error' => "idm not found!",
                ], 404);
            }

            return response()->json([
                'status' => true,
                'idm' => $idm,
            ], 200);
        }
        try {

            $allIdm = idmModel::all();
            return response()->json([
                'status' => true,
                'idm' => $allIdm,
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
                'tahun' => 'required|numeric|unique:idm', // Nama harus diisi, string, dan tidak lebih dari 255 karakter
                "skor" => 'required|decimal:0,10',
                "status" => "required",
                "targetStatus" => 'required',
                "skorMinimal" => "required|decimal:0,10",
                "penambahan" => 'required|decimal:0,10',
                "skorIKS" => "required|decimal:0,10",
                "skorIKE" => 'required|decimal:0,10',
                "skorIKL" => 'required|decimal:0,10'
            ]);


            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 400);
            }

            idmModel::create([
                'tahun' => $request->tahun,
                "skor" => $request->skor,
                "status" => $request->status,
                "targetStatus" => $request->targetStatus,
                "skorMinimal" => $request->skorMinimal,
                "penambahan" => $request->penambahan,
                "skorIKS" => $request->skorIKS,
                "skorIKE" => $request->skorIKE,
                "skorIKL" => $request->skorIKL
            ]);

            return response()->json([
                'message' => "idm Successfully create!",
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
            "skor" => 'required|decimal:0,10',
            "status" => "required",
            "targetStatus" => 'required',
            "skorMinimal" => "required|decimal:0,10",
            "penambahan" => 'required|decimal:0,10',
            "skorIKS" => "required|decimal:0,10",
            "skorIKE" => 'required|decimal:0,10',
            "skorIKL" => 'required|decimal:0,10'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 400);
        }
        try {
            // return $tahun = [/tahun => $tahun];
            $idm = idmModel::find($id);

            if (!$idm) {
                return response()->json([
                    'message' => "Id idm not available!",
                ], 404);
            }

            $idm->tahun = $request->tahun;
            $idm->skor = $request->skor;
            $idm->status = $request->status;
            $idm->targetStatus = $request->targetStatus;
            $idm->skorMinimal = $request->skorMinimal;
            $idm->penambahan = $request->penambahan;
            $idm->skorIKS = $request->skorIKS;
            $idm->skorIKE = $request->skorIKE;
            $idm->skorIKL = $request->skorIKL;

            $idm->save();

            return response()->json([
                'message' => "idm successfully update!",
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
            $idm = idmModel::find($request->id);
            if (!$idm) {
                return response()->json([
                    'status' => false,
                    'error' => 'idm not faund!',
                ], 404);
            }

            $idm->delete();
            return response()->json([
                'status' => true,
                'message' => 'idm sucessfully delete!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
