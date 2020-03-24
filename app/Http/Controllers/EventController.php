<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Event;

class EventController extends Controller
{
    public function index($id)
    {
        $user = User::findOrFail($id);
        $events = Event::where('id', $id)->get();
        $event = $events[0];
        //sta prosledjujemo viewu? prosledjujemo objekat user, pa u viewu mozemo da pristupamo njemu i njegovim poljima
        return view('event', array(
            'user' => $user,
            'events' => $events,
            'event' =>$event
        ));
    }
}
