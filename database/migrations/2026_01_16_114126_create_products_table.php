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
        $table->id(); // Auto-increment primary key
        $table->string('name', 255); // Required
        $table->text('description')->nullable(); // Nullable
        $table->decimal('price', 10, 2); // Required
        $table->integer('stock')->default(0); // Default: 0
        $table->timestamps(); // created_at & updated_at
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
