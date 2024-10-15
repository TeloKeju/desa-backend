<?php

// namespace App\Http\Controllers;
namespace App\Http\Controllers\Api;



use App\Models\NewsModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ImageService;
use Exception;

// note request mungkin masih salah
class NewsController extends Controller
{
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
        try {
            if ($request->id) {
                $news = NewsModel::findOrFail($request->id);
                return response()->json([
                    'status' => true,
                    'news' => $news,
                ], 200);
            }

            $allNews = NewsModel::all();
            return response()->json([
                'status' => true,
                'news' => $allNews,
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
                'title' => 'required|string|max:255', // Pastikan judul diisi dan tidak lebih dari 255 karakter
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
            $upload = $this->imageService->uploadImage($request->file('image'));

            if ($upload['status'] === false) {
                throw new Exception($upload['message']);
            }

            NewsModel::create([
                'id' => $slug,
                'title' => $request->title,
                'image' => $upload["path"],
                'content' => $request->content,
            ]);
            return response()->json([
                'message' => "berhasil menambah news!",
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

        // $validator = Validator::make($request->all(), ([
        //     'title' => 'required|string|max:255', // Pastikan judul diisi dan tidak lebih dari 255 karakter
        //     'content' => 'required|string|max:1000', // Pastikan konten diisi dan tidak lebih dari 1000 karakter
        // ]));

        $request->validate([
            'title' => 'required|string|max:255', // Pastikan judul diisi dan tidak lebih dari 255 karakter
            'content' => 'required|string|max:1000',
        ]);
        return $request->title;
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'req' => $request->input(),
            ], 400);
        }
        try {
            $news = NewsModel::findOrFail($id);

            if (!$news) {
                return response()->json([
                    'message' => "Id News not available!",
                ], 200);
            }

            if($request->file("image")){
                $upload = $this->imageService->uploadImage($request->file("image"));
                $path = $upload['path'];

                $this->imageService->dropImage($news["image"]);

                $news->image($path);
            }

            if ($news->title != $request->title) {
                $news->id(self::slugify($request->title));
                $news->title($request->title);
            }
            $news->content($request->content);
            $news->save();

            return response()->json([
                'message' => "berhasil mengupdate news!",
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
            $news = NewsModel::findOrFail($request->id);
            if (!$news) {
                return response()->json([
                    'status' => false,
                    'error' => 'News not faund!',
                ], 404);
            }


            $this->imageService->dropImage($news["image"]);

            $news->delete();
            return response()->json([
                'status' => true,
                'message' => 'News sucessfully delete!',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
