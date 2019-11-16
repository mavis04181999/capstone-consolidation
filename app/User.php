<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    // protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];
    
    // instead of fillable use guarded
    protected $guarded = [];

    // for json and array retrieval those attributes are the hidden
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // scope functions
    public function scopeUser($query){
        return $query->where('role', 'user');
    }

    public function scopeOrganizer($query){
        return $query->where('role', 'organizer');
    }
    // relationships
    public function department(){
        return $this->belongsTo(Department::class);
    }
    
    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function section(){
        return $this->belongsTo(Section::class);
    }
    
}
