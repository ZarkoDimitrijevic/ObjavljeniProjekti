<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Event;


class EventController extends Controller
{

    public function viewEvent($id) 
    {
        $event = Event::findOrFail($id);
        $idUser = $event->user_id;
        $user = User::findOrFail($idUser);

        /*posto smo u modelu Event napisali funkciju User, mogli
        bismo da idemo $event->user->id, sto bi nam vratio celog usera
        odnosno njegov id. Nije bilo nuzno raditi kao ovo sto je uradjeno, jer upravo
        ti modeli sluze da se tako lako kreces.
        */
        return view('event', array(    
            'event' => $event,
            'user' => $user,
        ));
    }
}
