<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
// use SebastianBergmann\Environment\Console;

class ImageService
{
    public function uploadImage($request, $path)
    {
        try {
            $image = $request;
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/' . $path . '/'), $imageName);
            return [
                "status" => true,
                "path" => "images/" . $path . "/" . $imageName,
            ];
        } catch (\Exception $e) {
            return [
                "status" => false,
                "message" => $e->getMessage()
            ];
        }
    }

    public function dropImage($path)
    {
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
