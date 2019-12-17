<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    // allow mass assignable
    protected $guarded = [];

    // relationships
    public function events () {
        
        return $this->belongsToMany(Event::class)->withTimestamps();
    }
}
