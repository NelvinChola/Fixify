<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            // Payment fields
            $table->enum('payment_method', ['cash', 'mobile_money', 'bank_transfer', 'card', 'other'])->nullable()->after('paid_at');
            $table->string('transaction_reference', 100)->nullable()->after('payment_method');
        });
    }

    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method',
                'transaction_reference',
            ]);
        });
    }
};