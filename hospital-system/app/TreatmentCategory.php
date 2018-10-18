<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TreatmentCategory extends Model
{
  protected $table = "treatment_categories";

  // relationships
  public function treatments(){
    return $this->hasMany('App\Treatment','category_id','id');
  }
}
