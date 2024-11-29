<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});
Route::get('/products', function () {
    //csv data with all products
    //create csv file from products
    $products = \App\Models\Product::all();
    $csv = \League\Csv\Writer::createFromFileObject(new SplTempFileObject);
    $csv->insertOne(['nev', 'sku', 'ean', 'price', 'price_kivitelezok', 'price_kp_elore_harminc', 'price_kp_elore_huszonot']);
    foreach ($products as $product) {
        $csv->insertOne([$product->nev, $product->sku, $product->ean, $product->price, $product->price_kivitelezok, $product->price_kp_elore_harminc, $product->price_kp_elore_huszonot]);
    }
    $csv->download('products.csv');

    // return response()->download(storage_path('app/products.csv'));
});
require __DIR__.'/auth.php';
