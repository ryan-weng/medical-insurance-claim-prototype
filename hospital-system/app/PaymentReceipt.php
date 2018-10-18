<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentReceipt extends Model
{
  protected $table = "payment_receipts";

  // relationships
  public function payment_details(){
    return $this->hasMany('App\PaymentDetail', 'receipt_id', 'id');
  }

  public function patient(){
    return $this->belongsTo('App\Patient', 'patient_id', 'id');
  }
}
