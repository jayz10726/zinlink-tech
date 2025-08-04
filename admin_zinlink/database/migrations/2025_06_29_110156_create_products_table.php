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
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->string('brand');
            $table->string('model');
            $table->string('processor')->nullable();
            $table->string('ram')->nullable();
            $table->string('storage')->nullable();
            $table->string('display')->nullable();
            $table->string('graphics')->nullable();
            $table->string('operating_system')->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->string('image_url')->nullable();
            $table->string('category')->default('laptop');
            $table->enum('condition', ['new', 'used', 'refurbished'])->default('new');
            $table->string('warranty')->nullable();
            $table->boolean('is_active')->default(true);
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
