<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    // enable mass assignable
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function evaluate() {
        return $this->hasMany(Evaluate::class);
    }

    public function ticket() {
        return $this->hasOne(Ticket::class);
    }

    public function isEvaluate() {
        return $this->where('is_evaluate', true);
    }

    public function notEvaluate() {
        return $this->where('is_evaluate', false);
    }

}
