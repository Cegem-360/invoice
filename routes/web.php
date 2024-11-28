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
    $csv->insertOne(['nev', 'sku', 'ean', 'price']);
    foreach ($products as $product) {
        $csv->insertOne([$product->nev, $product->sku, $product->ean, $product->price]);
    }
    $csv->download('products.csv');

    // return response()->download(storage_path('app/products.csv'));
});
require __DIR__.'/auth.php';
