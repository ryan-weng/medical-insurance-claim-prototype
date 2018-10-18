<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
  protected $table = "reservations";

  // relationships
  public function room(){
    return $this->belongsTo('App\Room', 'room_id', 'id');
  }

  public function medical_record(){
    return $this->belongsTo('App\MedicalRecord', 'medical_record_id', 'id');
  }
}
