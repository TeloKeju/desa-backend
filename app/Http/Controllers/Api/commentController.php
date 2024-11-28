<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\commentModel;
use App\Models\UmkmModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class commentController extends Controller
{
    //
    public static function get(Request $request)
    {

        try {
            $umkm = $request->id;
            $comment = UmkmModel::find($umkm)->comment;

            return response()->json(
                [
                    'status' => true,
                    'comment' => $comment,
                ],
                200
            );
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
                "nama" => 'required',
                "rating" => 'required|Numeric',
                "comment" => 'required|string|max:255',
                'umkm_id' => 'required|Numeric|exists:umkm,id',
            ]);


            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 400);
            }

            commentModel::create([
                "nama" => $request->nama,
                "rating" => $request->rating,
                'date' => $request->date,
                'comment' => $request->comment,
                'umkm_id' => $request->umkm_id,
            ]);

            return response()->json([
                'message' => "comment Successfully create!",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public static function update(Request $request, $id)
    {
        // return $request->bantuanCaleg;
        $validator = Validator::make($request->all(), [
            "nama" => 'required',
            "rating" => 'required|Numeric',
            "comment" => 'required|string|max:255',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 400);
        }
        try {
            $comment = commentModel::find($id);
            if (!$comment) {
                return response()->json([
                    'message' => "Id bansos not available!",
                ], 404);
            }

            $comment->nama = $request->nama;
            $comment->rating = $request->rating;
            $comment->date = $request->date;
            $comment->comment = $request->comment;

            $comment->save();

            return response()->json([
                'message' => "comment successfully update!",
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
            $comment = commentModel::find($request->id);
            if (!$comment) {
                return response()->json([
                    'status' => false,
                    'error' => 'comment not faund!',
                ], 404);
            }

            $comment->delete();
            return response()->json([
                'status' => true,
                'message' => 'comment sucessfully delete!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
