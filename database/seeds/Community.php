<?php

use Illuminate\Database\Seeder;

class Community extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('community')->insert(array(
         	array(
           		'community'   => 'Kapu'
        	)
         ));
    }
}
