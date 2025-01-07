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
            $table->string('username')->unique();
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->integer('score')->default(0);
            $table->integer('trust_score')->default(0);
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_holder_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username', 'phone', 'avatar', 'score', 'trust_score', 'gender',
                'bank_account_number', 'bank_name', 'account_holder_name'
            ]);
        });
    }
};
