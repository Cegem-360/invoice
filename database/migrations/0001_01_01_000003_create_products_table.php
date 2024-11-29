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
            $table->string('nev')->nullable();
            $table->string('sku')->nullable();
            $table->string('ean')->nullable();
            $table->string('price')->nullable(); //listaár
            $table->string('price_kivitelezok')->nullable(); //kivitelezői ár
            $table->string('price_kp_elore_harminc')->nullable(); //készpénz előre 30 %
            $table->string('price_kp_elore_huszonot')->nullable(); //készpénz előre 25 %
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
