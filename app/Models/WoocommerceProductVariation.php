<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WoocommerceProductVariation extends Model
{
    protected $fillable = [
        'wordpress_id',
        'name',
        'sku',
    ];

    public function product()
    {
        return $this->belongsTo(WoocommerceProduct::class);
    }
}
