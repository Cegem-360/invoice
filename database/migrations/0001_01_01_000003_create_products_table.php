<?php

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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            //cikkszam
            $table->string('sku')->unique();
            //Arcsoport_Brutto 1, vagy 0, az eladási ár nettó, vagy bruttó
            $table->boolean('price_group_gross')->default(0);
            //Arcsoport_Ar az eladási ár
            $table->decimal('price_group_price', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
