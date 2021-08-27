<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for( $i = 0; $i <= 20; $i++ ) {
            $faker = Faker::create();

            $gender = $faker->randomElement(['male', 'female']);
            Employee::create([
                'name'      => $faker->firstName($gender) . ' ' . $faker->lastName,
                'gender'    => $gender,
                'address'   => $faker->address
            ]);
        }
    }
}
