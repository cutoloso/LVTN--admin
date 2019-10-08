<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable()->default('');
            $table->string('code')->nullable()->default('');
            $table->string('alias')->nullable()->default('');
            $table->bigInteger('price')->nullable()->default(0);
            $table->bigInteger('price_sale')->nullable()->default(0);
            $table->bigInteger('parent')->nullable()->default(0);
            $table->smallInteger('quatity')->nullable()->default(0);
            $table->smallInteger('warranty')->nullable()->default(12);
            $table->boolean('active')->nullable()->default(0);
            $table->text('description')->nullable()->default('');
            $table->boolean('best_sale')->nullable()->default(0);
            $table->boolean('best_feature')->nullable()->default(0);

            $table->bigInteger('sup_id')->nullable()->default(0);
            $table->bigInteger('bra_id')->nullable()->default(0);
            $table->bigInteger('att_gr_id')->nullable()->default(0);
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
        Schema::dropIfExists('products');
    }
}
