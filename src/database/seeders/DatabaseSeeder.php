<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

        User::create([
            'name'     => "Juan Pérez", 
            'email'    => "juan@example.com", 
            'email_verified_at' => now(),
            'password' => bcrypt("secret123"),
        ]);

        User::factory()->count(10)->create();
        
        DB::table('parkings')->insert([
            [
                'nombre' => 'Calle Rivadavia y Santiago',
                'direccion' => 'Calle Rivadavia y Santiago',
                'latitud' => -26.82483,
                'longitud' =>  -65.20016,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Calle Rivadavia y San Juan',
                'direccion' => 'Calle Rivadavia y San Juan',
                'latitud' => -26.826196,
                'longitud' =>   -65.200512,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Calle Rivadavia y Cordoba',
                'direccion' => 'Calle Rivadavia y Cordoba',
                'latitud' => -26.827507,
                'longitud' =>   -65.200822,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Calle San Juan y Laprida',
                'direccion' => 'Calle San Juan y Laprida',
                'latitud' =>  -26.825916,
                'longitud' =>  -65.201966 ,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Calle Laprida y Cordoba',
                'direccion' => 'Calle Laprida y Cordoba',
                'latitud' => -26.825925,
                'longitud' => -65.201961 ,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Calle monteagudo y santiago ',
                'direccion' => 'Calle monteagudo y santiago ',
                'latitud' => -26.825097,
                'longitud' => -65.198668 ,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ]);
        
        
    }
}
