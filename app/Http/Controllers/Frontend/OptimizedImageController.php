<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

class OptimizedImageController extends Controller
{
    public function show(Request $request, $path)
    {
        try {
            $imagePath = 'public/' . $path;
            
            if (!Storage::exists($imagePath)) {
                abort(404);
            }

            $image = Storage::get($imagePath);
            $img = Image::make($image);

            // Get requested dimensions
            $width = $request->get('w');
            $height = $request->get('h');
            $quality = $request->get('q', 80);

            // Resize if dimensions provided
            if ($width || $height) {
                $img->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            // Convert to WebP if supported
            if ($request->get('webp') && $img->mime() !== 'image/webp') {
                $img->encode('webp', $quality);
            } else {
                $img->encode($img->extension(), $quality);
            }

            // Cache the optimized image
            $cacheKey = 'optimized_' . md5($path . $width . $height . $quality . ($request->get('webp') ? 'webp' : ''));
            $cachePath = 'public/cache/' . $cacheKey . '.' . $img->extension();
            
            if (!Storage::exists($cachePath)) {
                Storage::put($cachePath, $img->getEncoded());
            }

            return Response::make($img->getEncoded())
                ->header('Content-Type', $img->mime())
                ->header('Cache-Control', 'public, max-age=31536000, immutable')
                ->header('ETag', md5($img->getEncoded()));

        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function thumbnail(Request $request, $path)
    {
        try {
            $imagePath = 'public/' . $path;
            
            if (!Storage::exists($imagePath)) {
                abort(404);
            }

            $image = Storage::get($imagePath);
            $img = Image::make($image);

            // Create thumbnail (max 300x300)
            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $img->encode('webp', 75);

            return Response::make($img->getEncoded())
                ->header('Content-Type', 'image/webp')
                ->header('Cache-Control', 'public, max-age=31536000, immutable');

        } catch (\Exception $e) {
            abort(404);
        }
    }
}
