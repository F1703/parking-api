<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ParkingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('parkings')->insert([
            [
                'nombre' => 'Parking Central',
                'direccion' => 'Calle Falsa 123',
                'latitud' => -34.603722,
                'longitud' => -58.381592,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

    }
}
