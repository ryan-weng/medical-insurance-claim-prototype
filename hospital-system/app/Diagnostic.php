<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnostic extends Model
{
    protected $table = "diagnostics";

    // relationships
    public function doctor(){
      return $this->belongsTo('App\Doctor', 'doctor_id', 'id');
    }

    public function medical_record(){
      return $this->belongsTo('App\MedicalRecord','medical_record_id', 'id');
    }
}
