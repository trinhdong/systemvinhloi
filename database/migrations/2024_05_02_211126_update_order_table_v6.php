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
            $table->integer('bank_account_id2')->nullable()->after('payment_date');
            $table->json('bank_account_info2')->nullable()->after('bank_account_id2');
            $table->integer('payment_method2')->nullable()->after('bank_account_id2');
            $table->string('bank_code2')->nullable()->after('payment_method2');
            $table->string('bank_name2')->nullable()->after('bank_code2');
            $table->string('bank_customer_name2')->nullable()->after('bank_name2');
            $table->date('payment_date2')->nullable()->after('bank_customer_name2');
            $table->decimal('paid_remaining', 20, 2)->nullable()->after('bank_customer_name2');
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
