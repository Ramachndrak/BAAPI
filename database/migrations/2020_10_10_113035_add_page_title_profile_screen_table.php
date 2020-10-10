<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPageTitleProfileScreenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles_screen', function (Blueprint $table) {
            $table->string('page_title')->after('blood_group_id');
        });

        Schema::table('religions_background', function (Blueprint $table) {
            $table->string('page_title')->after('rashi');
        });

        Schema::table('educations_details', function (Blueprint $table) {
            $table->string('page_title')->after('annual_income');
        });

        Schema::table('family_details', function (Blueprint $table) {
            $table->string('page_title')->after('sister_not_married');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('family_details', function (Blueprint $table) {
            $table->dropColumn('address');
        });
        Schema::table('educations_details', function (Blueprint $table) {
            $table->dropColumn('address');
        });
        Schema::table('religions_background', function (Blueprint $table) {
            $table->dropColumn('address');
        });
        Schema::table('profiles_screen', function (Blueprint $table) {
            $table->dropColumn('address');
        });
    }
}
