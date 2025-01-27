<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WoocommerceProduct extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'wordpress_id',
        'name',
        'sku',
    ];

    public function woocommerceProductVariation(): HasMany
    {
        return $this->hasMany(WoocommerceProductVariation::class);
    }
}
