<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Claimable extends Model
{
    protected $table = "claimables";

    public function claim_requests(){
      return $this->belongsToMany('App\Claim', 'claim_requests_claimables', 'claimable_id', 'claim_request_id')->withPivot('amount');
    }

    public function policies(){
      return $this->belongsToMany('App\Policy', 'insurance_policies_claimables', 'claimable_id', 'insurance_policy_id');
    }
}
