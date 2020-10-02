<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMaternalGotramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('religions_background', function (Blueprint $table) {
            $table->integer('maternal_gotram')->after('gotram');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('religions_background', function (Blueprint $table) {
            $table->dropColumn('maternal_gotram');
        });
    }
}
