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
        $tables = ['users', 'categories', 'products', 'areas', 'customers', 'orders', 'order_details', 'discounts'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->timestamp('deleted_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = ['users', 'categories', 'products', 'areas', 'customers', 'orders', 'order_details', 'discounts'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('deleted_at');
            });
        }
    }
};
