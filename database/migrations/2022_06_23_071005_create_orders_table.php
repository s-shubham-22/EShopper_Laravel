<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('b_fname');
            $table->string('b_lname');
            $table->string('b_email');
            $table->string('b_mobile');
            $table->string('b_addr_1');
            $table->string('b_addr_2');
            $table->string('b_country');
            $table->string('b_city');
            $table->string('b_state');
            $table->string('b_zip');
            $table->string('s_fname');
            $table->string('s_lname');
            $table->string('s_email');
            $table->string('s_mobile');
            $table->string('s_addr_1');
            $table->string('s_addr_2');
            $table->string('s_country');
            $table->string('s_city');
            $table->string('s_state');
            $table->string('s_zip');
            $table->string('status');
            $table->bigInteger('created_by')->nullable()->default(0);
            $table->bigInteger('update_by')->nullable()->default(0);
            $table->bigInteger('deleted_by')->nullable()->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
