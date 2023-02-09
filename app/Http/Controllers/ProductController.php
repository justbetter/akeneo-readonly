<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Intervention\Image\ImageManagerStatic;
use JustBetter\Akeneo\Facades\Akeneo;

class ProductController extends Controller
{
    public function index(): Response
    {
        return response()->view('products');
    }

    public function show(Product $product): Response
    {
        return response()->view('product', ['product' => $product]);
    }

    public function image(Request $request): Response
    {
        $code = $request->get('code');
        $width = $request->get('width');
        $height = $request->get('height');

        if (! is_string($code)) {
            abort(404);
        }

        $api = Akeneo::getProductMediaFileApi();

        $file = $api->download($code);

        $image = ImageManagerStatic::make($file->getBody());

        if ($width || $height) {
            $image->resize($width, $height);
        }

        return $image->response();
    }
}
