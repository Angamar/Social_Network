<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //ovo se navodi ukoliko je ime modela razlicito od imena tabele u bazi, tj. ako se ne prati konvencija (baza mnozina, model jednina)
    protected $table='posts';
    protected $id = 'id'; //ukoliko se primarni kljuc ne zove id.
    public $timestamps = true; //kolone created_at i updated_at se automatski popunjavaju prilikom kreiranja novog reda

    public function user()
    {
        //ovaj post pripada samo jednom Useru
        return $this->belongsTo('App\User');
        //sada Post ima jos jedno polje, objekat User, i mozemo pristupiti njegovim poljima
    }
}

