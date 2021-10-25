<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AllocatedItemsForChd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allocated_items_for_chd', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('allocation_list_id');
            $table->unsignedBigInteger('iar_item_id');
            $table->unsignedBigInteger('receiving_office');
            $table->integer('request_qty');
            $table->integer('approved_qty');
            $table->longText('reason_for_qty');
            $table->enum('issuance_status', ['issued', 'pending'])->default('pending');
            $table->date('issued_date')->nullable();
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
        //
    }
}
