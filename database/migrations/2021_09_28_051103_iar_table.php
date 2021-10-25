<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iar_table', function (Blueprint $table) {
            $table->id('id');
            $table->string('iar_number')->unique();
            $table->unsignedBigInteger('pr_id')->nullable();
            $table->string('ptr_number')->nullable();
            $table->string('logistics_officer')->nullable();
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
        Schema::dropIfExists('iar_table');
    }
}
