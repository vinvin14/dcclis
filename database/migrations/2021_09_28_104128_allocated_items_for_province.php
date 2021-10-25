<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AllocatedItemsForProvince extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allocated_items_for_province', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('allocation_list_id');
            $table->unsignedBigInteger('iar_item_id');
            $table->integer('requested_qty');
            $table->integer('approved_qty')->nullable();
            $table->longText('reason_for_qty')->nullable();
            $table->enum('issuance_status', ['issued', 'pending'])->default('pending');
            $table->date('issued_date')->nullable();
            $table->string('recipient');
            $table->timestamps();

            $table->foreign('allocation_list_id')->references('id')->on('allocation_list_for_province')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('iar_item_id')->references('id')->on('iar_items_table')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('allocated_items_for_province');
    }
}
