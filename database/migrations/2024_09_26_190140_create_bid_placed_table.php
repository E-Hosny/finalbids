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
        Schema::create('bid_placed', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('product_id')->nullable();
            $table->string('project_id')->nullable();
            $table->string('bid_amount')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('buyers_premium')->nullable();
            $table->tinyInteger('mail_sent')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('outbid')->default(0);
            $table->integer('sold')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bid_placed');
    }
};
