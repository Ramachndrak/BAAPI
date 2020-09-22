<?php

use Illuminate\Database\Seeder;

class MotherTongue extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('mother_tongue')->insert(array(
         	array(
           		'mother_tongue'   => 'Telugu'
        	),
        	array(
           		'mother_tongue'   => 'English'
        	),
        	array(
           		'mother_tongue'   => 'Hindi'
        	),
        ));
    }
}
