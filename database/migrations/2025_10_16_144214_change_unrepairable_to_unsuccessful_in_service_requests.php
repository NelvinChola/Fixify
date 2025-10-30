<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For MySQL - change unrepairable to unsuccessful in enum
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE service_requests MODIFY COLUMN status ENUM('submitted', 'assessed', 'assigned', 'diagnosis', 'repairing', 'completed', 'unsuccessful', 'sent_back') NOT NULL DEFAULT 'submitted'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // For MySQL - revert to unrepairable
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE service_requests MODIFY COLUMN status ENUM('submitted', 'assessed', 'assigned', 'diagnosis', 'repairing', 'completed', 'unrepairable', 'sent_back') NOT NULL DEFAULT 'submitted'");
        }
    }
};