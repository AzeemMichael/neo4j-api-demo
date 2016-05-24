<?php

use Illuminate\Database\Seeder;

class DoctorsLabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Doctor::class, 50)->create();
    }
}
