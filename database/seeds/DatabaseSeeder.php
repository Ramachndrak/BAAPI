<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
         $this->call(ProfileSeeder::class);
         $this->call(ProfileCreatedBy::class);
         $this->call(BloodGroup::class);
         $this->call(Religion::class);
         $this->call(Community::class);
         $this->call(SubCommunity::class);
         $this->call(MotherTongue::class);
         $this->call(HighQualification::class);
         $this->call(FaceFairSeeder::class);
    }
}
