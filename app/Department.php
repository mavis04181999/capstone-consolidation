<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    // allow mass assignable:
    protected $guarded = [];

    // relationships
    public function users() {

        return $this->hasMany(User::class);
    }

    public function courses() {
        
        return $this->hasMany(Course::class);
    }

}
