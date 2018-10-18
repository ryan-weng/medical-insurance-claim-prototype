<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalHistoryItem extends Model
{
  protected $table = "medical_history_items";

  // relationships
  public function medical_history(){
    return $this->hasMany('App\MedicalHistory', 'item_id', 'id');
  }
}
