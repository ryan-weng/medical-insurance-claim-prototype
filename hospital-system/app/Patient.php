<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
  protected $table = "patients";

  // relationships
  public function medical_records(){
    return $this->hasMany('App\MedicalRecord', 'patient_id', 'id');
  }

  public function medical_history(){
    return $this->hasMany('App\MedicalHistory', 'patient_id', 'id');
  }

  public function payment_receipts(){
    return $this->hasMany('App\PaymentReceipt', 'patient_id', 'id');
  }
}
