<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RisItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ris_items_table', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('ris_id');
            $table->unsignedBigInteger('iar_item_id');
            $table->integer('request_qty');
            $table->integer('approved_qty');
            $table->longText('reason_for_qty')->nullable();
            $table->enum('status', ['approved', 'declined', 'pending'])->default('pending');
            $table->string('verified_by')->nullable();
            $table->timestamps();

            
            $table->foreign('ris_id')->references('id')->on('ris_table');
            $table->foreign('iar_item_id')->references('id')->on('iar_items_table');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ris_items_table');
    }
}
