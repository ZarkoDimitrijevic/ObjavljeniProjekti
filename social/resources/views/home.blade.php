@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Communication</div>
                <div class="card-body">
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{session()->get('success')}}
                        </div>
                    @elseif(session()->has('error'))
                        <div class="alert alert-success">
                            {{session()->get('error')}}
                        </div>
                    @endif
                    <form action="/home" method="POST">
                        @csrf <!--Forma nece da radi bez ovoga-->
                        <textarea class="form-control" name="content" id="" cols="30" rows="5" placeholder="What's on your mind ... ?"></textarea>
                        <input type="submit" class="btn btn-primary" value="Post!">
                    </form>
                </div>
                <hr>
                <div class="card-body">
                    <!--@if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif-->
                    
                    @foreach($objave as $objava)
                        <h5><img src="images/{{$objava->user->id}}.png" width=30px height=40px onerror="this.onerror=null; this.src='images/default.png'"><a href="user/{{$objava->user->id}}">{{$objava->user->name}}({{$objava->user->email}})</a></h5>
                        <h5>{{$objava->content}}</h5>
                        <small>{{$objava->updated_at->format('d-m-Y.')}}</small>
                        <small>{{$objava->created_at->diffForHumans()}}</small>
                        <hr>
                    @endforeach
                    
                    
                </div>
            </div>
            <div class="card-header">Events</div>
                <div class="card-body">
                    @foreach($events as $event)
                    <h5><a href="event/{{$event->id}}">{{$event->name}}({{$event->date}})</a></h5>
                    @endforeach
                </div>
            </div>
        <div class="col-md-4">
        @if(count($mutuals))
            <div class="card">
                <div class="card-header">
                    Mutual users:
                </div>
                <div class="card-body">        
                    @foreach($mutuals as $mutual)
                        <h5>{{$mutual->name}}</h5>
                    @endforeach        
                </div>
                
            </div>
        @else
            <div class="card">
                <div class="card-header">
                    You can start mutualing :) !
                </div>
            </div>
        @endif
        @if(count($following))
            <div class="card">
                <div class="card-header">
                    Users I'm following:
                </div>
                <div class="card-body">        
                    @foreach($following as $follower)
                        <h5>{{$follower->name}}</h5>
                    @endforeach        
                </div>
                
            </div>
        @else
            <div class="card">
                <div class="card-header">
                    You can start following !
                </div>
            </div>
        @endif

        @if(count($followers))
            <div class="card">
                <div class="card-header">
                    Users who are following me:
                </div>
                <div class="card-body">        
                    @foreach($followers as $follower)
                        <h5><a href="user/{{$follower->id}}">{{$follower->name}}</a></h5>
                    @endforeach        
                </div>
                
            </div>
        @else
            <div class="card">
                <div class="card-header">
                    They can start follow You !
                </div>
            </div>
        @endif

        @if(count($others))
            <div class="card">
                <div class="card-header">
                    Suggestions:
                </div>
                <div class="card-body">        
                    @foreach($others as $other)
                        <h5>{{$other->name}}</h5>
                    @endforeach        
                </div>
                
            </div>
        @else
            <div class="card">
                <div class="card-header">
                    Bravo, you are well connected :) !
                </div>
            </div>
        @endif
        
        </div>
    </div>
</div>
@endsection
