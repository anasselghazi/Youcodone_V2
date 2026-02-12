<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'restaurant_id',
        'date_reservation',
        'heure_reservation',
        'nombre_personne',
        

    ];
    public function restaurant(){
        return $this->belongsTo(Resaurant::class);
    }
}
