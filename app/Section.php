<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    // protected $table = 'sections';

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
