<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnsToNullableInProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('auction_type_id')->nullable()->change();
            $table->unsignedBigInteger('project_id')->nullable()->change();
            $table->decimal('reserved_price', 10, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('auction_type_id')->nullable(false)->change();
            $table->unsignedBigInteger('project_id')->nullable(false)->change();
            $table->decimal('reserved_price', 10, 2)->nullable(false)->change();
        });
    }
}
