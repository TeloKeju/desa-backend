<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\pembelianModel;
use App\Models\UmkmModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class pembelianController extends Controller
{
    public static function dateSplicer($date)
    {
        list($year, $month, $day) = explode("-", $date);
        $date = [
            "year" => $year,
            "month" => $month, // Perbaikan: "mounth" diganti menjadi "month" karena salah eja
            "day" => $day // Perbaikan: array tambahan dihilangkan karena tidak diperlukan
        ];
        return $date;
    }
    //
    public static function get(Request $request)
    {
        try {
            if ($request->bulan) {
                if (!$request->tahun) {
                    throw new Exception("When there is a month, a year must also be present.");
                }
            }
            $pembelian = UmkmModel::find($request->umkm_id)->pembelian;

            if ($request->tahun) {
                $tempYear = [];
                foreach ($pembelian as $buy) {
                    if (self::dateSplicer($buy["date"])["year"] == $request->tahun) {
                        $tempYear[] = $buy;
                    }
                }

                if ($request->bulan) {
                    $TempMonth = [];
                    foreach ($tempYear as $buy) {
                        if (self::dateSplicer($buy["date"])["month"] == $request->bulan) {
                            $TempMonth[] = $buy;
                        }
                    }

                    return response()->json([
                        'status' => true,
                        'pembelian' => $TempMonth
                    ], 200);
                }

                return response()->json([
                    'status' => true,
                    'pembelian' => $tempYear
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public static function add(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'umkm_id' => 'required|numeric', // Nama harus diisi, string, dan tidak lebih dari 255 karakter
            ]);


            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 400);
            }

            pembelianModel::create([
                "umkm_id" => $request->umkm_id,
            ]);

            return response()->json([
                'message' => "pembelian Successfully create!",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
    public static function delete(Request $request)
    {
        try {
            $pembelian = pembelianModel::find($request->id);
            if (!$pembelian) {
                return response()->json([
                    'status' => false,
                    'error' => 'News not faund!',
                ], 404);
            }


            $pembelian->delete();
            return response()->json([
                'status' => true,
                'message' => 'pembelian sucessfully delete!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
