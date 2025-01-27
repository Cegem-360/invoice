<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nev',
        'sku',
        'ean',
        'price',
        'price_kivitelezok',
        'price_kp_elore_harminc',
        'price_kp_elore_huszonot',

    ];

    public function woocomerceProductVariation(): HasOne
    {
        return $this->hasOne(WoocommerceProductVariation::class);
    }
}
