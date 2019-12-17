<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    // enable mass assignable
    protected $guarded = [];

    // relation ships
    public function form() {
        return $this->belongsTo(Form::class);
    }
}
