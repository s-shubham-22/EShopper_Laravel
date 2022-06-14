<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name', '80')->nullable();
            $table->string('slug', '80')->nullable();
            $table->string('image', '80')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->bigInteger('created_by')->nullable()->default(0);
            $table->bigInteger('update_by')->nullable()->default(0);
            $table->bigInteger('deleted_by')->nullable()->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brands');
    }
}
