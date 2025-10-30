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
    Schema::create('device_issue_device', function (Blueprint $table) {
        $table->id();
        $table->foreignId('device_id')->constrained()->onDelete('cascade');
        $table->foreignId('device_issue_id')->constrained()->onDelete('cascade');
        $table->decimal('cost', 10, 2)->default(0);
        $table->timestamps();

        $table->unique(['device_id', 'device_issue_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_issue_device');
    }
};
