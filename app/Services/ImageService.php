<?php

namespace App\Services;

class ImageService
{
    public function uploadImage($request)
    {
        try {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            return [
                "status" => true,
                "path" => "images/" + $imageName,
            ];
        } catch (\Exception $e) {
            return [
                "status" => false,
                "message" => $e->getMessage()
            ];
        }
    }
}
