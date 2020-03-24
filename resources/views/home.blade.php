@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class ="card-body">
                @if(session()->has('success'))
                    <div class="alert alert-success">
                    {{session()->get('success')}}
                    </div>
                @elseif(session()->get('error'))
                    <div class="alert alert-danger">
                    {{session()->get('error')}}
                    </div>
                @endif
                <form action="/home" method="post">
                @csrf
                <textarea name="content" rows="5" cols="30" 
                class="form-control" placeholder="Tell us something...">
                
                </textarea>
                <br>
                <input type="submit" class="btn btn-primary" value="Post">
                </div>


                <div class="card-body">
              


                  @foreach($objave as $objava)
                   
                     @php
                    $path = "images/" . $objava->user->id .".jpg";
                    @endphp
                      <h5>
                      <a href="user/{{$objava->user->id}}">
                      @if(!file_exists($path))
                      <img src='images/default.jpg' width="50">
                      @else
                      <img src='images/{{$objava->user->id}}.jpg' width="50">
                      @endif

                      {{$objava->user->name}}</a>
                      ({{$objava->user->email}})</h5>
                      @if($objava->user->id == Auth::user()->id)
                      <p style='color:green'>{{$objava->content}}</p>
                      @else
                      <p>{{$objava->content}}</p>
                      @endif
                      <small>{{$objava->created_at->format("d.m.Y.")}}</small>
                      <small>{{$objava->created_at->diffForHumans() }}</small>
                      <hr>
                  @endforeach
                </div>
            </div>    
                <br>
            <div class="card">
                <div class="card-header">Events</div>
                <div class="card-body">
                 @foreach($events as $event)
                      <h5><a href="event/{{$event->id}} ">{{$event->name}}</a></h5> <p>{{$event->date}}<p>
                      <small>event created by</small>
                      <small>{{ $event->user->name }}</small>
                      <small>{{$event->created_at->diffForHumans() }}</small>
                      <hr>
                  @endforeach
                </div>
            </div>
        </div>
        <div class ="col-md-4">
            @if(count($mutuals))
                
                 <div class="card">
                    <div class="card-header">
                    Mutual friends
                    </div>
                    <div class="card-body">
                     @foreach($mutuals as $mutual)
                        <a href="user/{{$mutual->id}}">{{$mutual->name}}</a>
                    @endforeach
                    </div>
                </div>  
            @endif
            <br>
            @if(count($following))
            
                <div class="card">
                    <div class="card-header">
                    Users I'm following
                    </div>
                    <div class="card-body">
                    @foreach($following as $follow)
                        <a href="user/{{$follow->id}}">{{$follow->name}}</a>
                    @endforeach
                    </div>
                </div>  
            @endif
            <br>
            @if(count($followers))
            
                <div class="card">
                    <div class="card-header">
                    My followers
                    </div>
                    <div class="card-body">
                    @foreach($followers as $follower)
                        <a href="user/{{$follower->id}}">{{$follower->name  }}</a><input type=""
                    @endforeach
                    </div>
                </div>  
            @endif 
            <br>
            @if(count($others))
                
                 <div class="card">
                    <div class="card-header">
                    More people
                    </div>
                    <div class="card-body">
                     @foreach($others as $other)
                        <a href="user/{{$other->id}}">{{$other->name}}</a>
                    @endforeach
                    </div>
                </div>  
            @endif
            <br>  
        </div>
    </div>
</div>
@endsection
