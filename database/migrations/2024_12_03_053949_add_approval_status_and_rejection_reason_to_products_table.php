<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddApprovalStatusAndRejectionReasonToProductsTable extends Migration
{
    public function up()
    {
        // التحقق من وجود العمود قبل إضافته
        if (!Schema::hasColumn('products', 'approval_status')) {
            Schema::table('products', function (Blueprint $table) {
                $table->enum('approval_status', ['pending', 'approved', 'rejected'])
                      ->default('pending')
                      ->after('is_popular');
            });
        }

        // التحقق من وجود العمود قبل إضافته أو تعديله
        if (!Schema::hasColumn('products', 'rejection_reason')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('rejection_reason')
                      ->nullable()
                      ->after('approval_status')
                      ->charset('utf8mb4')
                      ->collation('utf8mb4_unicode_ci');
            });
        } else {
            // تعديل الترميز للحقل الموجود
            Schema::table('products', function (Blueprint $table) {
                $table->string('rejection_reason')
                      ->nullable()
                      ->charset('utf8mb4')
                      ->collation('utf8mb4_unicode_ci')
                      ->change();
            });
        }

        // تعديل الترميز الافتراضي للجدول (اختياري)
        DB::statement('ALTER TABLE products CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    }

    public function down()
    {
        // التحقق من وجود العمود قبل حذفه
        if (Schema::hasColumn('products', 'approval_status')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('approval_status');
            });
        }

        if (Schema::hasColumn('products', 'rejection_reason')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('rejection_reason');
            });
        }
    }
}
