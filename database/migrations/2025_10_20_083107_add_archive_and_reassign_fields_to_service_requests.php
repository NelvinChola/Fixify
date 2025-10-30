<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->string('archive_reason')->nullable()->after('status');
            $table->text('archive_notes')->nullable()->after('archive_reason');
            $table->timestamp('archived_at')->nullable()->after('archive_notes');
            $table->text('reassign_notes')->nullable()->after('archived_at');
            $table->timestamp('reassigned_at')->nullable()->after('reassign_notes');
        });
    }

    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn([
                'archive_reason',
                'archive_notes', 
                'archived_at',
                'reassign_notes',
                'reassigned_at'
            ]);
        });
    }
};