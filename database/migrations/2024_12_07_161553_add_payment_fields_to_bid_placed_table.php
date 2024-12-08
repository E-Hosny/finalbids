<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bid_placed', function (Blueprint $table) {
            // حقول حالة الدفع
            $table->enum('payment_status', [
                'unpaid',    // لم يتم الدفع (الحالة الافتراضية)
                'pending',   // في انتظار الدفع
                'paid',      // تم الدفع بنجاح
                'failed'     // فشل الدفع
            ])->default('unpaid')->after('status');

            // حقول MyFatoorah
            $table->string('myfatoorah_payment_id')->nullable()->after('payment_status');
            $table->string('myfatoorah_invoice_id')->nullable()->after('myfatoorah_payment_id');
            
            // تفاصيل الدفع
            $table->json('payment_data')->nullable()->after('myfatoorah_invoice_id');
            $table->timestamp('paid_at')->nullable()->after('payment_data');

            // إنشاء indexes للبحث السريع
            $table->index(['payment_status']);
            $table->index(['myfatoorah_payment_id', 'myfatoorah_invoice_id']);
            $table->index(['paid_at']);
        });
    }

    public function down()
    {
        Schema::table('bid_placed', function (Blueprint $table) {
            // حذف الindexes
            $table->dropIndex(['payment_status']);
            $table->dropIndex(['myfatoorah_payment_id', 'myfatoorah_invoice_id']);
            $table->dropIndex(['paid_at']);

            // حذف الأعمدة
            $table->dropColumn([
                'payment_status',
                'myfatoorah_payment_id',
                'myfatoorah_invoice_id',
                'payment_data',
                'paid_at'
            ]);
        });
    }
};