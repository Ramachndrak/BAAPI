<?php

use Illuminate\Database\Seeder;


class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('profilesfor')->insert(array(
         	array(
           		'profile_for'   => 'Self'
        	),
        	array(
           		'profile_for'   => 'Son'
        	),
        	array(
           		'profile_for'   => 'Daughter'
        	),
        	array(
           		'profile_for'   => 'Brother'
        	),
        	array(
           		'profile_for'   => 'Sister'
        	),
        	array(
           		'profile_for'   => 'Friend'
        	),
        	array(
           		'profile_for'   => 'Relative'
        	)
         ));
    }
}
