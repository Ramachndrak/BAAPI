<?php

use Illuminate\Database\Seeder;

class FaceFairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('face_fair')->insert(array(
         	array(
           		'face_fair'   => 'Very Fair'
        	),
        	array(
           		'face_fair'   => 'Fair'
        	),
        	array(
           		'face_fair'   => 'Medium'
        	),
        	array(
           		'face_fair'   => 'Dark/Darker'
        	),
        	array(
           		'face_fair'   => 'Too Dark/Darkest'
        	)
        ));
    }
}
