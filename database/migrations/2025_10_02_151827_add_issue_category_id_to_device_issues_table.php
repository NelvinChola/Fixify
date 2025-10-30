<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('device_issues', function (Blueprint $table) {
        $table->foreignId('issue_category_id')
              ->nullable()
              ->constrained('issue_categories')
              ->cascadeOnDelete();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('device_issues', function (Blueprint $table) {
            //
        });
    }
};
