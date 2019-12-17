<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluate extends Model
{
    // enable mass assignable
    protected $guarded = [];

    public function evaluation() {
        return $this->belongsTo(Evaluation::class);
    }
}
