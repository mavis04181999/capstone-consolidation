<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // enable mass assignable
    protected $guarded = [];

    // relationship
    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
