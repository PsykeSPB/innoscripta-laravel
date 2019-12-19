<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positionables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->morphs('positionable');
            $table->unsignedInteger('quantity');
            $table->decimal('price_mult', 12, 2)->default(1);
            $table->decimal('price_add', 12, 2)->default(0);

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->unique(['order_id', 'positionable_id', 'positionable_type'], 'unique_position');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::create('positionables', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
        });
        Schema::dropIfExists('positionables');
    }
}
