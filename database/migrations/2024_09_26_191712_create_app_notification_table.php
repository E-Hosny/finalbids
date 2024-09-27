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
        Schema::create('app_notification', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->text('message')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('product_id', 255)->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('project_id', 255)->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('user_id', 255)->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->tinyInteger('is_read')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_notification');
    }
};
