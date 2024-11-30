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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->nullable();
            $table->integer('auction_type_id');
            $table->integer('category_id');
            $table->decimal('reserved_price', 10, 2);
            $table->decimal('Increment', 10, 2)->nullable();
            $table->datetime('auction_end_date');
            $table->text('description'); 
            $table->boolean('is_popular')->default(false);
            $table->enum('status', ['new', 'open', 'suspended', 'closed']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
