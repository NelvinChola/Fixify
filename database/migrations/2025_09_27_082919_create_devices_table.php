<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
    Schema::create('devices', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('category_id');
    $table->string('name'); // e.g., "iPhone 14"
    $table->string('brand');
    $table->string('model')->nullable();
    $table->string('image'); // store image path
    $table->timestamps();

    $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
    });

    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
