<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IaritemsRisitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iaritems_risitems', function (Blueprint $table) {
            // $table->bigIncrements('id');
            // $table->unsignedBigInteger('iar_item_id');
            // $table->unsignedBigInteger('ris_item_id');

            $table->foreignId('iaritem_id');
            $table->foreignId('risitem_id');
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
