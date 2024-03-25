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
            $table->integer('payment_type')->after('shipping_address');
            $table->decimal('deposit', 20, 2)->nullable()->after('payment_date');
            $table->string('bank_code')->nullable()->after('payment_method');
            $table->string('bank_name')->nullable()->after('payment_method');
            $table->string('bank_customer_name')->nullable()->after('payment_method');
            $table->integer('payment_method')->nullable(false)->change();
            $table->integer('is_print_red_invoice')->default(false)->after('payment_status');
            $table->renameColumn('note', 'order_note');
            $table->decimal('order_total', 20, 2)->change();
            $table->decimal('order_discount', 20, 2)->change();
            $table->decimal('order_total_product_price', 20, 2)->after('order_discount');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 20, 2)->change();
        });
        Schema::table('order_details', function (Blueprint $table) {
            $table->decimal('unit_price', 20, 2)->change();
            $table->decimal('discount_percent', 10, 2)->after('unit_price');
            $table->decimal('product_price', 20, 2)->after('unit_price');
        });
        Schema::table('discounts', function (Blueprint $table) {
            $table->decimal('discount_percent', 5, 2)->change();
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
