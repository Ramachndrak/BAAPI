<?php

use Illuminate\Database\Seeder;

class Religion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('religions')->insert(array(
         	array(
           		'religion'   => 'Hindu'
        	),
        	array(
           		'religion'   => 'Christian'
        	),
        	array(
           		'religion'   => 'Musilims'
        	)
         ));
    }
}
