<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ParTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('par_table', function (Blueprint $table) {
            $table->id('id');
            $table->string('par_number')->unique();
            $table->unsignedBigInteger('ris_item_id');
            $table->string('mr_to')->nullable();
            $table->integer('office')->nullable();
            $table->string('property_number')->unique()->nullable();
            $table->timestamps();

            $table->foreign('ris_item_id')->references('id')->on('ris_items_table');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('par_table');
    }
}
