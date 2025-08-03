<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Parking",
 *     type="object",
 *     title="Parking",
 *     required={"id", "nombre", "direccion", "latitud", "longitud"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Parking centro"),
 *     @OA\Property(property="direccion", type="string", example="San Martín 124"),
 *     @OA\Property(property="latitud", type="number", format="float", example=-26.74721),
 *     @OA\Property(property="longitud", type="number", format="float", example=-65.24686)
 * )
*/

class Parking extends Model
{
    use HasFactory;

    protected $table = "parkings"; 
    protected $fillable = [
        "nombre","direccion", 'latitud', 'longitud' 
    ];

}
 