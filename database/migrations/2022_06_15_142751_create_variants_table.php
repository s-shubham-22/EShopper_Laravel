<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->integer('price')->nullable();
            $table->integer('sale_price')->nullable();
            $table->integer('quantity')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('created_by')->nullable()->default(0);
            $table->bigInteger('update_by')->nullable()->default(0);
            $table->bigInteger('deleted_by')->nullable()->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variants');
    }
}
