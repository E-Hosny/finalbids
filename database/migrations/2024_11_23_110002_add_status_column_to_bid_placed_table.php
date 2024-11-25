<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusColumnToBidPlacedTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('bid_placed', function (Blueprint $table) {
            // إضافة حقل `status` كـ tinyint مع قيمة افتراضية
            if (!Schema::hasColumn('bid_placed', 'status')) {
                $table->tinyInteger('status')
                      ->default(0)
                      ->after('mail_sent')
                      ->comment('Status of the bid: 0 = pending, 1 = approved, 2 = rejected');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('bid_placed', function (Blueprint $table) {
            // إزالة الحقل `status` إذا كان موجودًا
            if (Schema::hasColumn('bid_placed', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
}
