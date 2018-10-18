<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    protected $table = "insurance_policies";

    public function users(){
      return $this->belongsToMany('App\User', 'insurance_policies_users', 'insurance_policy_id', 'user_id');
    }

    public function hospitals(){
      return $this->belongsToMany('App\Policy', 'insurance_policies_hospitals', 'insurance_policy_id', 'hospital_id');
    }

    public function claimables(){
      return $this->belongsToMany('App\Claimable', 'insurance_policies_claimables', 'insurance_policy_id', 'claimable_id');
    }

    public function claims(){
      return $this->hasMany('App\Claim', 'insurance_policy_id', 'id');
    }
}
