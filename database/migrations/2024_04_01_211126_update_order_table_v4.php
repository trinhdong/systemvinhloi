<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('has_print_red_invoice')->default(0)->after('is_print_red_invoice');
            $table->integer('has_update_quantity')->default(0)->after('has_print_red_invoice');
            $table->integer('payment_check_type')->default(1)->after('payment_status');
            $table->dateTime('order_date')->change();
            $table->date('delivery_appointment_date')->nullable()->after('payment_date');
            $table->integer('bank_account_id')->nullable()->after('payment_method');
            $table->json('bank_account_info')->nullable()->after('bank_account_id');
            $table->integer('payment_due_day')->nullable()->after('payment_date');
        });
        Schema::table('order_details', function (Blueprint $table) {
            $table->decimal('discount_percent', 7, 4)->change();
            $table->decimal('discount_price', 20, 2)->after('discount_percent');
            $table->text('discount_note')->nullable()->after('discount_price');
        });
        Schema::table('discounts', function (Blueprint $table) {
            $table->decimal('discount_percent', 7, 4)->change();
            $table->decimal('discount_price', 20, 2)->after('discount_percent');
            $table->text('note')->nullable()->after('discount_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
