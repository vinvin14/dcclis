<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ics_table', function (Blueprint $table) {
            $table->id('id');
            $table->string('ics_number')->unique();
            $table->integer('is_subject_for_assembly')->default(0);
            $table->integer('qty');
            $table->integer('office')->nullable();
            $table->unsignedBigInteger('ris_item_id');
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
        Schema::dropIfExists('ics_table');
    }
}
