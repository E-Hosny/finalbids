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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->integer('role')->nullable()->default(2)->comment('1=admin, 2=user');
            $table->string('email')->unique();
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('profile_image', 255)->nullable();
            $table->integer('otp')->unsigned()->nullable();
            $table->string('refer_code', 100)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};