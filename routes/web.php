<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});
Route::get('/products', function () {
    // csv data with all products
    // create csv file from products
    $products = Product::wherehas('woocomerceProductVariation')->get();
    $csv = \League\Csv\Writer::createFromFileObject(new SplTempFileObject);
    $csv->insertOne(['nev', 'sku', 'group_id', 'ean', 'price', 'price_kivitelezok', 'price_kp_elore_harminc', 'price_kp_elore_huszonot']);
    foreach ($products as $product) {
        /** @var Product $product */
        $csv->insertOne([$product->nev, $product->sku, $product->woocomerceProductVariation()->first()->product_id, $product->ean, $product->price, $product->price_kivitelezok, $product->price_kp_elore_harminc, $product->price_kp_elore_huszonot]);
    }
    $csv->download('products.csv');

    // return response()->download(storage_path('app/products.csv'));
});
require __DIR__.'/auth.php';
