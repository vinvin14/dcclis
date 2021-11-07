<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IarItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iar_items_table', function (Blueprint $table) {
            $table->id('id');
            $table->integer('beginning_qty');
            $table->integer('current_qty');
            $table->integer('issued_qty')->nullable();
            $table->unsignedBigInteger('iar_id');
            $table->unsignedBigInteger('item_id');
            $table->double('price')->nullable();
            $table->unsignedBigInteger('receiving_office');
            $table->enum('status', ['cleared','for_replacement','cancelled'])->nullable();
            $table->date('expiration_date')->nullable();
            $table->string('lot_batch_number')->nullable();
            $table->string('recorded_by')->nullable();

            $table->foreign('iar_id')->references('id')->on('iar_table');
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
        Schema::dropIfExists('iar_items_table');
    }
}
