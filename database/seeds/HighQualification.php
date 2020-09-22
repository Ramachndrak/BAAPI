<?php

use Illuminate\Database\Seeder;

class HighQualification extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('high_qualification')->insert(array(
         	array(
           		'qualification'   => 'Diplamo'
        	),
        	array(
           		'qualification'   => 'Degree'
        	),
        	array(
           		'qualification'   => 'Graduate'
        	),
        	array(
           		'qualification'   => 'Post Graduate'
        	),
        ));
    }
}
