<?php

use Illuminate\Database\Seeder;

class ProfileCreatedby extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profiles_created_by')->insert(array(
         	array(
           		'profiles_created_by'   => 'My Self'
        	),
        	array(
           		'profiles_created_by'   => 'Father'
        	),
        	array(
           		'profiles_created_by'   => 'Mother'
        	),
        	array(
           		'profiles_created_by'   => 'Friend'
        	),
        	array(
           		'profiles_created_by'   => 'Brother'
        	),
        	array(
           		'profiles_created_by'   => 'Sister'
        	),
        	array(
           		'profiles_created_by'   => 'Relatives'
        	)
         ));
    }
}
