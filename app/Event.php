<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public $timestamps = true;



    public function user()
    {
        //ovaj Event pripada samo jednom Useru
        return $this->belongsTo('App\User');
        //sada Event ima jos jedno polje, objekat User, i mozemo pristupiti njegovim poljima
    }
}
