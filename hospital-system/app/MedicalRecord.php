<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $table = "medical_records";

    // relationships
    public function diagnostic(){
      return $this->hasOne('App\Diagnostic', 'medical_record_id', 'id');
    }

    public function reservation(){
      return $this->hasOne('App\Reservation', 'medical_record_id', 'id');
    }

    public function patient(){
      return $this->belongsTo('App\Patient', 'patient_id', 'id');
    }

    public function treatments(){
      return $this->hasMany('App\MedicalRecordTreatment', 'medical_record_id', 'id');
    }
}
