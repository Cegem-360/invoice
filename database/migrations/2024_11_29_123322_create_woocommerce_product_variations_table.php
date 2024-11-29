<?php

use App\Models\WoocommerceProduct;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('woocommerce_product_variations', function (Blueprint $table) {
            $table->id();
            $table->string('wordpress_id')->nullable();
            $table->string('name')->nullable();
            $table->string('sku')->nullable();
            $table->foreignIdFor(WoocommerceProduct::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('woocommerce_product_variations');
    }
};
