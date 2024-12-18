<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'nev',
        'sku',
        'ean',
        'price',
        'price_kivitelezok',
        'price_kp_elore_harminc',
        'price_kp_elore_huszonot',

    ];
}
