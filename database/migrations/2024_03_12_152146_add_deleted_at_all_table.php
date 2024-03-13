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
        Schema::table('users', function (Blueprint $table) {
            $table->date('deleted_at')->nullable();
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->date('deleted_at')->nullable();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->date('deleted_at')->nullable();
        });
        Schema::table('areas', function (Blueprint $table) {
            $table->date('deleted_at')->nullable();
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->date('deleted_at')->nullable();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->date('deleted_at')->nullable();
        });
        Schema::table('order_details', function (Blueprint $table) {
            $table->date('deleted_at')->nullable();
        });
        Schema::table('discounts', function (Blueprint $table) {
            $table->date('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};
