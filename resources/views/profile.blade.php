@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
         <div class ="col-md-4">
            <div class="card">
                        <div class="card-header">
                        <h4>{{$user->name}}</h4>
                        </div>
                        <div class="card-body">
                        @php
                    $path = "images/" . $user->id .".jpg";
                        @endphp

                        @if(!file_exists($path))
                        <img src='/images/default.jpg' width="200">
                        @else
                        <img src='/images/{{$user->id}}.jpg' width="200">
                        @endif
                        </div>
            </div>
         </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$user->name}}</div>

                <div class="card-body">
                  @foreach($posts as $objava)
                      <h5>
                        {{$objava->user->name}}({{$objava->user->email}})</h5>
                      <p>{{$objava->content}}</p>
                      <small>{{$objava->created_at->format("d.m.Y.")}}</small>
                      <small>{{$objava->created_at->diffForHumans() }}</small>
                      <hr>
                  @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
