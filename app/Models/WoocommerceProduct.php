<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WoocommerceProduct extends Model
{
    protected $fillable = [
        'wordpress_id',
        'name',
        'sku',
    ];

    public function variations()
    {
        return $this->hasMany(WoocommerceProductVariation::class);
    }
}
