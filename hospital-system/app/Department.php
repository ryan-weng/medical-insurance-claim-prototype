<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = "departments";

    // relationships
    public function doctors(){
      return $this->hasMany('App\Doctor', 'department_id', 'id');
    }
}
