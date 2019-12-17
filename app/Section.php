<?php

namespace App;

use App\Department;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    // allow mass assignable
    protected $guarded = [];

    // relationship
    public function users(){

        return $this->hasMany(User::class);
    }

    public function course(){
        
        return $this->belongsTo(Course::class);
    }
}
