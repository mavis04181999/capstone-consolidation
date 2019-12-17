<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    // enable mass assignable
    protected $guarded = [];

    public function event() {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
