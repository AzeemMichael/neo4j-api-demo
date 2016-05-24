<?php

use Illuminate\Database\Seeder;

/**
 * Class PatientsLabelSeeder
 */
class PatientsLabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Patient::class, 50)->create()->each(function(\App\Patient $patient) {

            // give 70% patients appointment with doctors
            if((float)rand()/(float)getrandmax() >= 0.3) {

                $doctors = \App\Doctor::skip(rand(0,45))->take(5)->get();

                if ($doctors->count() > 0) {
                    foreach ($doctors as $doctor) {
                        $patient->appointments($doctor)
                            ->save(factory(\App\Appointment::class)->make());
                    }
                }
            }
        });
    }
}
