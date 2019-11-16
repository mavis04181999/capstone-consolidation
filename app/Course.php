<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    // protected $table = 'courses';
    
    // allow mass assignable
    protected $guarded = [];

    // relationships

    public function users(){
        return $this->hasMany(User::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }
}
