<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
  protected $table = "payment_details";

  // relationships
  public function treatment(){
    return $this->belongsTo('App\MedicalRecordTreatment', 'records_treatment_id', 'id');
  }

  public function receipt(){
    return $this->belongsTo('App\PaymentReceipt', 'receipt_id', 'id');
  }
}
