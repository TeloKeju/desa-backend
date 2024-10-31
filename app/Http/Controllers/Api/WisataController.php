<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WisataModel;
use Illuminate\Http\Request;
use App\Services\ImageService;
use Illuminate\Support\Facades\Validator;
use Exception;

class WisataController extends Controller
{
    //
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public static function slugify($text, string $divider = '-')
    {
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, $divider);
        $text = preg_replace('~-+~', $divider, $text);
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public static function get(Request $request)
    {
        if ($request->id) {
            $wisata = WisataModel::find($request->id);

            if (!$wisata) {
                return response()->json([
                    'status' => false,
                    'error' => "wisata not found!",
                ], 404);
            }
            return response()->json([
                'status' => true,
                'wisata' => $wisata,
            ], 200);
        }


        try {
            $allWisata = WisataModel::all();
            return response()->json([
                'status' => true,
                'wisata' => $allWisata,
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
                'title' => 'required|string|max:255|unique:wisata,title', // Pastikan judul diisi dan tidak lebih dari 255 karakter
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Pastikan judul diisi dan tidak lebih dari 255 karakter
                'content' => 'required|string|max:1000', // Pastikan konten diisi dan tidak lebih dari 1000 karakter
            ]);




            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(), // Mengembalikan pesan kesalahan
                ], 400);
            }




            $slug = self::slugify($request->title);
            $upload = $this->imageService->uploadImage($request->file('image'), 'wisata');

            if ($upload['status'] === false) {
                throw new Exception($upload['message']);
            }


            WisataModel::create([
                'id' => $slug,
                'title' => $request->title,
                'image' => $upload["path"],
                'content' => $request->content,
            ]);
            return response()->json([
                'message' => "berhasil menambah wisata!",
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
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
        ]);



        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 400);
        }
        try {
            $wisata = WisataModel::find($id);

            if (!$wisata) {
                return response()->json([
                    'message' => "Id wisata not available!",
                ], 404);
            }




            if ($request->file("image")) {
                $upload = $this->imageService->uploadImage($request->file("image"), 'wisata');
                $path = $upload['path'];
                $this->imageService->dropImage($wisata["image"]);
                $wisata->image = $path;
            }

            if ($wisata->title != $request->title) {
                $wisata->id = self::slugify($request->title);
                $wisata->title = $request->title;
            }
            $wisata->content = $request->content;
            $wisata->save();

            return response()->json([
                'message' => "berhasil mengupdate wisata!",
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
            $wisata = WisataModel::find($request->id);
            if (!$wisata) {
                return response()->json([
                    'status' => false,
                    'error' => 'wisata not faund!',
                ], 404);
            }


            $this->imageService->dropImage($wisata["image"]);

            $wisata->delete();
            return response()->json([
                'status' => true,
                'message' => 'wisata sucessfully delete!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
