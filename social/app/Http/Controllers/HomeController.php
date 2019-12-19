<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;//moramo da dodamo ovo - ukljucuje se model
use Auth; //klasa za ulogovanog korisnika, da bi Laravel proveravao ko je ulogovani korisnik, dakle koristis kad god ti je potreban ulogovan korisnik
//Auth::user() vraca ulogovanog korisnika i na primer Auth::user()->id vraca ti njegov id, pa mozes name ... i tako dalje, to je dakle objekat i ti mu pristupas po poljima
use App\User;
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
        $posts = Post::orderBy('created_at', 'desc')->get();//get metoda daje sve redove iz post tabele; nadovezujemo metode strelicom
        //var_dump($posts);

        $user = Auth::user();//to je logovani korisnik
        $following = $user->following;//ovo je kraci zapis - posto imamo funkciju u modelu koja vraca neki broj korisnika, onda je pisemo user->following, ali bez zagrada, to je zato sto Laravel automatski konvertuje metodu u polja, zagrade ne treba da stavljas nikako jer posle zeza, ne pravi niz kako bi trebalo ako ima zagrade. E sad, ta metoda ima return i ona ti vraca tacno ono sto ti treba.
        //$following = $user->following()->get() - ima isto znacenje, samo ti je gore kraaci oblik. Poenta je da kad stavis zagrade, on pravi objekat nad kojim dalje izvrsavas komande, a kad stavis bez zagrada on ti odmah da niz
        $followers = $user->followers;
        
        //odredjujemo mutual, following, followers i others
        $followingIds = $user->following->pluck('id')->toArray();//a evo recimo ovde following iako se nadovezuje posle nesto radi bez zagrada a nece sa zagradama
        //var_dump($followingIds); //- followingIds su idevi svih korisnika koje pratimo
        //var_dump($user->following->toArray());

        $followerIds = $user->followers->pluck('id')->toArray();//pluck kaze nemoj da mi saljes cele objekte vec samo ideve

        $mutualIds = array_intersect($followingIds, $followerIds);
        $followingIds = array_diff($followingIds, $mutualIds);
        $followerIds = array_diff($followerIds, $mutualIds);
        //var_dump($mutualIds);
        //var_dump($followingIds);
        //var_dump($followerIds);

        $mutuals = User::whereIn('id', $mutualIds)->orderBy('name')->get();
        /*ovde kazemo cupaj sve(select *) to je ovo ->get
        orderBy ti je sortiranje
        whereIn('id', $mutualIds) - to ti je ciji id je u nizu tom i tom
        */
        $followers = User::whereIn('id', $followerIds)->orderBy('name')->get();

        $following = User::whereIn('id', $followingIds)->orderBy('name')->get();

        $others = User::whereNotIn('id', array_merge($mutualIds, $followerIds, $followingIds, array($user->id)))->orderBy('name')->get();//morali smo da dodamo id logovanog korisnika da se on ne bi pojavljivao

        $events = Event::orderBy('created_at', 'desc')->get();

        return view('home', array(//drugi parametar je nesto sto saljemo pogledu, dakle saljemo mu niz
            'objave' => $posts,
            'following' => $following,//ide obican zarez jer je ovo array
            'followers' => $followers,
            'mutuals' => $mutuals,
            'others' => $others,
            'events' => $events,
        ));//objave ti prepoznaje view jer si tamo stavio @foreach($objave as $objava), a ovo $posts ti je iz ovog kontrolera
    }

    public function publish()
    {
        //$_POST['content'] - plain php
        $content = request('content');//laravel nacin da procitamo sta je u postu
        //echo Auth::user(); //logovani korisnik
        $id = Auth::user()->id;//id logovanog korisnika

        if(empty($content))
        {
            return redirect('/home')->with('error', 'Post can not be published!');
        }
        else
        {  
            //ubaciti novi red u tabelu Posts, odnosno insert u tabelu
            /*
            1) prvo kreirati novi objekat klase Post
            2) popunimo polja ovom objektu
            3) pozvati metodu save()
            */
            $post = new Post;
            $post->user_id = $id;
            $post->content = $content;
            $post->save();
            //redirekcija na home page
            return redirect('/home')->with('success', 'Post published!');//with cuva u sesiji poruku
        }
    }
    
}
