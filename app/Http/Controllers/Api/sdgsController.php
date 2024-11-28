<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\sdgsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class sdgsController extends Controller
{
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "skorSDGsDesa" => "required|decimal:0,2",
            "desaTanpaKemiskinan" => "required|decimal:0,2",
            "desaTanpaKelaparan" => "required|decimal:0,2",
            "desaSehatDanSejahtera" => "required|decimal:0,2",
            "pendidikanDesaBerkualitas" => "required|decimal:0,2",
            "keterlibatanPerempuanDesa" => "required|decimal:0,2",
            "desaLayakAirBersihDanSanitasi" => "required|decimal:0,2",
            "desaBerenergiBersihDanTerbarukan" => "required|decimal:0,2",
            "pertumbuhanEkonomiDesaMerata" => "required|decimal:0,2",
            "infrastrukturDanInovasiDesaSesuaiKebutuhan" => "required|decimal:0,2",
            "desaTanpaKesenjangan" => "required|decimal:0,2",
            "kawasanPemukimanDesaAmanDanNyaman" => "required|decimal:0,2",
            "konsumsiDanProduksiDesaSadarLingkungan" => "required|decimal:0,2",
            "desaTanggapPerubahanIklim" => "required|decimal:0,2",
            "desaPeduliLingkunganLaut" => "required|decimal:0,2",
            "desaPeduliLingkunganDarat" => "required|decimal:0,2",
            "desaDamaiBerkeadilan" => "required|decimal:0,2",
            "kemitraanUntukPembangunanDesa" => "required|decimal:0,2",
            "kelembagaanDesaDinamisDanBudayaDesaAdaptif" => "required|decimal:0,2",
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 400);
        }
        try {
            $sdgs = sdgsModel::find($id);
            if (!$sdgs) {
                return response()->json([
                    'message' => "Id SDGs not available!",
                ], 404);
            }

            $sdgs->skorSDGsDesa = $request->skorSDGsDesa;
            $sdgs->desaTanpaKemiskinan = $request->desaTanpaKemiskinan;
            $sdgs->desaTanpaKelaparan = $request->desaTanpaKelaparan;
            $sdgs->desaSehatDanSejahtera = $request->desaSehatDanSejahtera;
            $sdgs->pendidikanDesaBerkualitas = $request->pendidikanDesaBerkualitas;
            $sdgs->keterlibatanPerempuanDesa = $request->keterlibatanPerempuanDesa;
            $sdgs->desaLayakAirBersihDanSanitasi = $request->desaLayakAirBersihDanSanitasi;
            $sdgs->desaBerenergiBersihDanTerbarukan = $request->desaBerenergiBersihDanTerbarukan;
            $sdgs->pertumbuhanEkonomiDesaMerata = $request->pertumbuhanEkonomiDesaMerata;
            $sdgs->infrastrukturDanInovasiDesaSesuaiKebutuhan = $request->infrastrukturDanInovasiDesaSesuaiKebutuhan;
            $sdgs->desaTanpaKesenjangan = $request->desaTanpaKesenjangan;
            $sdgs->kawasanPemukimanDesaAmanDanNyaman = $request->kawasanPemukimanDesaAmanDanNyaman;
            $sdgs->konsumsiDanProduksiDesaSadarLingkungan = $request->konsumsiDanProduksiDesaSadarLingkungan;
            $sdgs->desaTanggapPerubahanIklim = $request->desaTanggapPerubahanIklim;
            $sdgs->desaPeduliLingkunganLaut = $request->desaPeduliLingkunganLaut;
            $sdgs->desaPeduliLingkunganDarat = $request->desaPeduliLingkunganDarat;
            $sdgs->desaDamaiBerkeadilan = $request->desaDamaiBerkeadilan;
            $sdgs->kemitraanUntukPembangunanDesa = $request->kemitraanUntukPembangunanDesa;
            $sdgs->kelembagaanDesaDinamisDanBudayaDesaAdaptif = $request->kelembagaanDesaDinamisDanBudayaDesaAdaptif;

            $sdgs->save();

            return response()->json([
                'message' => "SDGs successfully update!",
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
            $sdgs = sdgsModel::find($request->id);
            if (!$sdgs) {
                return response()->json([
                    'status' => true,
                    'error' => "SDGs not found!",
                ], 404);
            }

            return response()->json([
                'status' => true,
                'SDGs' => $sdgs,
            ], 200);
        }
        try {

            $sdgs = sdgsModel::all();
            return response()->json([
                'status' => true,
                'SDGs' => $sdgs,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
