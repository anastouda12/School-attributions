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
        $this->call(UsersTableSeeder::class);
        $this->call(ProfesseursTableSeeder::class);
        $this->call(GroupesTableSeeder::class);
        $this->call(CoursesTableSeeder::class);
        $this->call(AttributionsTableSeeder::class);
    }
}
