<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_image', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pro_id')->nullable()->default(0);
            $table->boolean('active')->nullable()->default(0);
            $table->string('img')->nullable()->default('');
            $table->boolean('front')->nullable()->default(0);
            $table->boolean('back')->nullable()->default(0);
            $table->boolean('above')->nullable()->default(0);
            $table->boolean('below')->nullable()->default(0);
            $table->boolean('left')->nullable()->default(0);
            $table->boolean('right')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_image');
    }
}
