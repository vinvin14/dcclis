<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AllocationListForProvince extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allocation_list_for_province', function (Blueprint $table) {
            $table->id('id');
            $table->string('allocation_list_number')->unique();
            $table->string('ptr_number')->unique();
            $table->unsignedBigInteger('office')->nullable();
            $table->string('created_by');
            $table->enum('status', ['issued', 'pending'])->default('pending');
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
        Schema::dropIfExists('allocation_list_for_province');
    }
}
