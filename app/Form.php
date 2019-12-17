<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    // enable mass assignable
    protected $guarded = [];

    // relationships:
    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function option() {
        return $this->hasMany(Option::class);
    }
}
