<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
  protected $table = "medical_histories";

  // relationships
  public function patient(){
    return $this->belongsTo('App\Patient', 'patient_id', 'id');
  }

  public function item(){
    return $this->belongsTo('App\MedicalHistoryItem', 'item_id', 'id');
  }
}
