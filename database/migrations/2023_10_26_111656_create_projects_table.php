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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('image_path');
            $table->datetime('start_date_time');
            $table->datetime('end_date_time');
            $table->integer('auction_type_id');
            $table->string('category_id', 255)->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->text('description')->nullable();
            $table->boolean('status')->default(true)->comment('Description Status: true (active) or false (inactive)');
            $table->boolean('is_trending')->default(false);
            $table->timestamps();
            $table->softDeletes();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
