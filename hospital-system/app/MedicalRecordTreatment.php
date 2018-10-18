<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalRecordTreatment extends Model
{
  protected $table = "medical_records_treatments";

  // relationships
  public function medical_record(){
    return $this->belongsTo('App\MedicalRecord', 'medical_record_id', 'id');
  }

  public function treatment(){
    return $this->belongsTo('App\Treatment', 'treatment_id', 'id');
  }

  public function payment_detail(){
    return $this->hasOne('App\PaymentDetail', 'records_treatment_id', 'id');
  }
}
