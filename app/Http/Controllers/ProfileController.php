<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{
    public function viewProfile($id)
    {
        //Nadjemo korisnika sa zadatim id-jem
       // $user = User::find($id); //ne mora da postoji PK
        $user = User::findOrFail($id); //mora da postoji PK
        $posts = $user->posts()->orderby('created_at', 'desc')->get();  //posts je na osnovu metode posts() iz klase User
    
        //sta prosledjujemo viewu? prosledjujemo objekat user, pa u viewu mozemo da pristupamo njemu i njegovim poljima
        return view('profile', array(
            'user' => $user,
            'posts' => $posts,
        ));
    }
}
