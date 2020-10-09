<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamilyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('father_name');
            $table->string('father_profession');
            $table->string('mother_name');
            $table->string('mother_profession');
            $table->string('no_of_brothers')->default(0);
            $table->string('brother_married')->default(0);
            $table->string('brother_not_married')->default(0);
            $table->string('no_of_sisters')->default(0);
            $table->string('sister_married')->default(0);
            $table->string('sister_not_married')->default(0);
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
        Schema::dropIfExists('family_details');
    }
}
