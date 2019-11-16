<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    // protected $table = 'departments';

    // allow mass assignable:
    protected $guarded = [];

    // relationships
    public function users(){
        return $this->hasMany(User::class);
    }

}
