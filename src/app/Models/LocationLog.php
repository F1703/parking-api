<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="LocationLog",
 *     type="object",
 *     title="LocationLog",
 *     required={"id", "parking_nombre", "distancia", "latitud", "longitud"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="parking_nombre", type="string", example="Parking centro"),
 *     @OA\Property(property="distancia", type="number", format="float", example="4.848"),
 *     @OA\Property(property="latitud", type="number", format="float", example=-26.74721),
 *     @OA\Property(property="longitud", type="number", format="float", example=-65.24686)
 * )
*/

class LocationLog extends Model
{
    use HasFactory;
    protected $table = "location_logs"; 
    protected $fillable = [
        'latitud', 'longitud' , "distancia", "parking_nombre"
    ];
}
