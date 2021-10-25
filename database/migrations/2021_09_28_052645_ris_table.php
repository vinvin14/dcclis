<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ris_table', function (Blueprint $table) {
            $table->id('id');
            $table->string('ris_number')->unique();
            $table->unsignedBigInteger('requesting_office');
            $table->string('approved_by')->nullable();
            $table->date('date_approved')->nullable();
            $table->enum('status', ['approved','declined','pending'])->default('pending');
            $table->longText('reason_for_status')->nullable();
            $table->enum('issuance_status', ['issued','pending'])->nullable();

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
        Schema::dropIfExists('ris_table');
    }
}
