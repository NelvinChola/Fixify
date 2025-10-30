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
        Schema::table('device_issues', function (Blueprint $table) {
            if (Schema::hasColumn('device_issues', 'cost')) {
                $table->dropColumn('cost');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('device_issues', function (Blueprint $table) {
            $table->decimal('cost', 10, 2)->nullable(); // restore cost if rolled back
        });
    }
};
