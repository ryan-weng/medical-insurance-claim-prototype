<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $table = "hospitals";

    public function policies(){
      return $this->belongsToMany('App\Policy', 'insurance_policies_hospitals', 'hospital_id', 'insurance_policy_id');
    }

    public function claims(){
      return $this->hasMany('App\Claim', 'hospital_id', 'id');
    }
}
