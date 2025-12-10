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
    Schema::create('notifications', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // who receives the notification
        $table->string('type'); // e.g., 'service_request_created', 'service_request_updated'
        $table->text('message'); // notification message
        $table->string('link')->nullable(); // optional URL to redirect
        $table->boolean('read')->default(false); // mark as read/unread
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
