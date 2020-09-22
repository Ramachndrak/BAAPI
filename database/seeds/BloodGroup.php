<?php

use Illuminate\Database\Seeder;

class BloodGroup extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('blood_group')->insert(array(
         	array(
           		'blood_group'   => 'O+'
        	),
        	array(
           		'blood_group'   => 'O-'
        	),
        	array(
           		'blood_group'   => 'AB+'
        	),
        	array(
           		'blood_group'   => 'AB-'
        	),
        	array(
           		'blood_group'   => 'A+'
        	),
        	array(
           		'blood_group'   => 'A-'
        	),
        	array(
           		'blood_group'   => 'B+'
        	),
        	array(
           		'blood_group'   => 'B-'
        	)
         ));
    }
}
