<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class ImageService
{
    public function uploadImage($request)
    {
        try {
            $image = $request;
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/news/'), $imageName);
            return [
                "status" => true,
                "path" => "images/news/" . $imageName,
            ];
        } catch (\Exception $e) {
            return [
                "status" => false,
                "message" => $e->getMessage()
            ];
        }
    }

    public function dropImage($path) {
        if (File::exists($path)) {
            File::delete($path);
            return [
                'status' => true,
                'message' => "file sucessfully delete!"
            ];
        }
        return [
            'status' => true,
            'message' => "file not exist!"
        ];
    }
}
