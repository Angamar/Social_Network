<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

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

    public function posts()
    {
        //kad kliknemo na jednog usera, da nam prikaze samo njegove postove
        //1:N, jedan korisnik ima vise objava
        //postoji vise objava, tako da ovde user hasMany Posts
        //dakle, ovom funkcijom User dobija jos jedno polje, koje je u stvari niz objekata klase Posts
        return $this->hasMany('App\Post');
    }

    public function events()
    {
        return $this->hasMany('App\Event');
    }

    public function following()
    {
        //niz korisnika koje korisnik prati
        return $this->belongsToMany('App\User', 'follow', 'user_id', 'friend_id');

    }

    public function followers()
    {
        //niz korisnika koji prate korisnika
        return $this->belongsToMany('App\User', 'follow', 'friend_id', 'user_id');

    }
}
