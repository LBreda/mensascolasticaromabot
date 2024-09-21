<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        collect([
            [
                'id'   => 1,
                'name' => 'Municipio I',
            ],
            [
                'id'   => 2,
                'name' => 'Municipio II',
            ],
            [
                'id'   => 4,
                'name' => 'Municipio III',
            ],
            [
                'id'   => 5,
                'name' => 'Municipio IV',
            ],
            [
                'id'   => 6,
                'name' => 'Municipio V',
            ],
            [
                'id'   => 8,
                'name' => 'Municipio VI',
            ],
            [
                'id'   => 9,
                'name' => 'Municipio VII',
            ],
            [
                'id'   => 11,
                'name' => 'Municipio VIII',
            ],
            [
                'id'   => 12,
                'name' => 'Municipio IX',
            ],
            [
                'id'   => 13,
                'name' => 'Municipio X',
            ],
            [
                'id'   => 15,
                'name' => 'Municipio XI',
            ],
            [
                'id'   => 16,
                'name' => 'Municipio XII',
            ],
            [
                'id'   => 18,
                'name' => 'Municipio XIII',
            ],
            [
                'id'   => 19,
                'name' => 'Municipio XIV',
            ],
            [
                'id'   => 20,
                'name' => 'Municipio XV',
            ],
        ])->each(fn($item) => \DB::table('municipi')->insert($item));

        collect([
            [
                'id'   => 1,
                'name' => 'Nido medi',
            ],
            [
                'id'   => 2,
                'name' => 'Nido grandi',
            ],
            [
                'id'   => 3,
                'name' => 'Ponte',
            ],
            [
                'id'   => 4,
                'name' => 'Infanzia',
            ],
            [
                'id'   => 5,
                'name' => 'Primaria',
            ],
            [
                'id'   => 6,
                'name' => 'Secondaria di I° grado',
            ],
        ])->each(fn($item) => \DB::table('gradi')->insert($item));
    }
}
