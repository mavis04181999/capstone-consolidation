<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    // allow mass assignable
    protected $guarded = [];

    // $relationship
    public function organizer() {

        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function features() {
        
        return $this->belongstoMany(Feature::class)->withTimestamps();
    }

    public function participants() {
        return $this->hasMany(Participant::class);
    }
}
