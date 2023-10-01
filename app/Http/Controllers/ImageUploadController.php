<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $uploadedImage = $request->file('upload'); // 'upload' is the name of the file input in the CKEditor upload dialog

        // Validate and store the image
        $path = $uploadedImage->store('images', 'public'); // 'images' is the storage folder, 'public' is the disk name

        // Generate the full URL to the uploaded image
        $imageUrl = asset('storage/' . $path);
        dd($imageUrl);

        // Return CKEditor response
        return response()->json([
            'url' => $imageUrl,
            'uploaded' => true,
        ]);
    }
}
