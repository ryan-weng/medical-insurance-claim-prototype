<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = "doctors";

    // relationships
    public function department(){
      return $this->belongsTo('App\Department', 'department_id', 'id');
    }

    public function diagnostics(){
      return $this->hasMany('App\Diagnostics', 'doctor_id', 'id');
    }
}
