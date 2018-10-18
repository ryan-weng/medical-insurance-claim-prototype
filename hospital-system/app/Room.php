<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
  protected $table = "rooms";

  // relationships
  public function reservations(){
    return $this->hasMany('App\Reservation', 'room_id', 'id');
  }
}
