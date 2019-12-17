<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    // allow mass assignable
    protected $guarded = [];

    // relationships

    public function users() {

        return $this->hasMany(User::class);
    }

    public function department() {

        return $this->belongsTo(Department::class);
    }

    public function sections() {
        
        return $this->hasMany(Section::class);
    }
}
