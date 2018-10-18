<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    protected $table = "claim_requests";

    public function user(){
      return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function claimables(){
      return $this->belongsToMany('App\Claimable', 'claim_requests_claimables', 'claim_request_id', 'claimable_id')->withPivot('amount');
    }

    public function hospital(){
      return $this->belongsTo('App\Hospital', 'hospital_id', 'id');
    }

    public function policy(){
      return $this->belongsTo('App\Policy', 'insurance_policy_id', 'id');
    }
}
