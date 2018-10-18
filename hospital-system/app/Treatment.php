<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
  protected $table = "treatments";

  // relationships
  public function category(){
    return $this->belongsTo('App\TreatmentCategory','category_id','id');
  }

  public function record(){
    return $this->hasMany('App\MedicalRecordTreatment', 'treatment_id', 'id');
  }
}
