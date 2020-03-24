<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post; //ukljucuje ses model
use Auth; //klasa za lovoganog korisnika
use App\User; //klasa za Usera (uvek mora da se postuju velika slova)
use App\Event;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    
        $posts = Post::orderBy('created_at','desc')->get(); //dohvati sve redove
        $events = Event::orderBy('date','asc')->get(); //dohvati sve redove
        $user = Auth::user();
        $followers = $user->followers;
        $following = $user->following; //following() je metoda is User klase, ali se zagrade u Laravelu ne pisu, vec se pristupa kao polju
        //moze i $users->following()->get() = to je pun zapis, gore je skraceni nacin

        //odredjujemo mutual, following, followers, others

        $followingIDs = $user->following->pluck('id')->toArray(); //id svih korisinika koje pratim
        $followersIDs = $user->followers->pluck('id')->toArray(); //id svih korisnika koji me prate
        $mutualIDs = array_intersect($followingIDs, $followersIDs); //id uzajamnih korisnika (presek onih koje pratim i koji me prate)
        $followingIDs = array_diff($followingIDs, $mutualIDs); //id samo onih koje pratim a mene ne prate
        $followersIDs = array_diff($followersIDs, $mutualIDs); //id samo onih koji me prate a ja njih ne

        //provera 
        //var_dump($followingIDs);
        //var_dump($followersIDs);
        //var_dump($mutualIDs);

        //User::get(); uzima sve korisnike SELECT * FROM Users
        //Users::orderBy('name')->get(); uzima sve korisnike i poredja ih po imenu SELECT * FROM Users ORDER BY name
        $mutuals =   User::whereIn('id', $mutualIDs)->orderBy('name')->get(); // SELECT * FROM Users WHERE id=$mutalIDs ORDER BY name
        $following = User::whereIn('id', $followingIDs)->orderBy('name')->get();
        $followers = User::whereIn('id', $followersIDs)->orderBy('name')->get();
        $others =    User::whereNotIn('id', array_merge($mutualIDs, $followersIDs, $followingIDs, array($user->id)))->orderBy('name')->get(); //array_merge = unija nizova
        
        //provera
        //var_dump($mutuals);

        return view('home', array(
            'objave' => $posts, 
            'following'=> $following,
            'followers'=> $followers,
            'mutuals' =>$mutuals,
            'others' => $others,
            'events' => $events
        )); //prosledili smo sve podatke view-u  
    }

    public function publish()
    {
        //$_POST['content'] --> ovo je bilo u obicnom PHP-u
        $content = request('content'); // u Laravelu preko funkcije request, dobijamo ono sto je submitovano
        // Auth::user(); ->logovani korisnik

        $id = Auth::user()->id; // id logovanog korisnika

        if(!empty($content))
        {
            //ubacivanje novog reda u tabelu posts
            //1) kreirati novi objekat modela Post
            $post = new Post();
            //2) popunimo polja ovom objektu
            $post->user_id = $id;
            $post->content = $content;
            //3) pozvati metodu save();
            $post->save();
            //Redirekcija na home page
            return redirect('/home')->with('success', 'Post published!'); //with dodaje poruku nakon publishovanje
        }
        else
        {
            return redirect('/home')->with('error', 'Error: Post cannot be empty');
        }
    }
}
