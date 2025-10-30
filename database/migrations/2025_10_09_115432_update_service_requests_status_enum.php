<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->enum('status', [
                'submitted',
                'assessed',
                'assigned',
                'diagnosis',
                'repairing',
                'completed',
                'unrepairable'
            ])->default('submitted')->change();
        });
    }

    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->string('status')->change(); // rollback to string if needed
        });
    }
};
