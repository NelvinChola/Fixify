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
        Schema::table('service_requests', function (Blueprint $table) {
            $table->decimal('additional_fees', 10, 2)->default(0)->after('total_cost');
            $table->text('additional_fees_notes')->nullable()->after('additional_fees');
            $table->timestamp('additional_fees_added_at')->nullable()->after('additional_fees_notes');
            $table->foreignId('additional_fees_added_by')->nullable()->after('additional_fees_added_at');
            
            // Add foreign key constraint
            $table->foreign('additional_fees_added_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropForeign(['additional_fees_added_by']);
            $table->dropColumn([
                'additional_fees',
                'additional_fees_notes', 
                'additional_fees_added_at',
                'additional_fees_added_by'
            ]);
        });
    }
};