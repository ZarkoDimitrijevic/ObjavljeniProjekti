@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><img src="../images/{{$user->id}}.png" width=30px height=40px>{{$user->name}}</div>

                <div class="card-body">
                    <!--@if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif-->
                    
                    @foreach($posts as $objava)
                        <h5>{{$objava->user->name}}({{$objava->user->email}})</h5>
                        <h5>{{$objava->content}}</h5>
                        <small>{{$objava->updated_at->format('d-m-Y.')}}</small>
                        <small>{{$objava->created_at->diffForHumans()}}</small>
                        <hr>
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
