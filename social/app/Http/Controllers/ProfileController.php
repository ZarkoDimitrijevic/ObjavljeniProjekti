<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;//moramo da ukljucimo ovo

class ProfileController extends Controller
{
    public function viewProfile($id)
    {
        //naci korisnika sa zadatim id-em
        //$user = User::find($id);//ne prijavljuje gresku ako id ne postoji, odnosno ne mora da postoji, tako nesto
        $user = User::findOrFail($id); //mora da postoji id
        $posts = $user->posts()->orderBy('created_at', 'desc')->get();
        //echo $user->posts;//na osnovu metode posts() iz klase User
        return view('profile', array(
            'user'=> $user,
            'posts' => $posts,
        ));

    }
}
