@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h3>{{$event->name}}</h3><p>created by {{ $event->user->name }}</p></div>
                <div class="card-body">

                <p>
                Date: {{ $event->date}}<br>
                Location: {{ $event->location}}
                </p>
                <small>{{$event->created_at->format("d.m.Y.")}}</small>
                <small>{{$event->created_at->diffForHumans() }}</small>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
