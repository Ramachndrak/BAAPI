<?php

use Illuminate\Database\Seeder;

class SubCommunity extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sub_community')->insert(array(
         	array(
           		'community_id'   => '1',
           		'sub_community'  => 'Telaga'
        	)
         ));
    }
}
