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
        Schema::table('users', function (Blueprint $table) {
            // Add the missing columns
            $table->string('verification_token')->nullable()->after('email_verified_at');
            $table->string('temp_password')->nullable()->after('verification_token');
            $table->boolean('is_temp_password')->default(false)->after('temp_password');
            
            // Make sure these columns exist (they might already be there)
            if (!Schema::hasColumn('users', 'contact')) {
                $table->string('contact')->nullable()->after('email');
            }
            
            if (!Schema::hasColumn('users', 'nrc')) {
                $table->string('nrc')->nullable()->after('contact');
            }
            
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('nrc');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'verification_token',
                'temp_password', 
                'is_temp_password'
            ]);
        });
    }
};