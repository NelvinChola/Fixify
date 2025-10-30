<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->enum('payment_status', ['pending', 'paid', 'partial'])->default('pending')->after('final_cost');
            $table->decimal('amount_paid', 10, 2)->default(0)->after('payment_status');
            $table->timestamp('paid_at')->nullable()->after('amount_paid');
        });
    }

    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'amount_paid', 'paid_at']);
        });
    }
};