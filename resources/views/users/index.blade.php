@extends('layouts.app')
@section('content')
    <div class="row">
        <ul class="list-group">
            @foreach($users as $user)
                <li class="list-group-item">{{$user->question}}
                    <span class="badge badge-primary badge-pill">{{count($user->votes)}}</span>
                    <a href="{{route('poll.edit', $user->id)}}" class="btn btn-info"
                       target="_self">{{__('Επεξεργασία')}}</a></li>
            @endforeach
        </ul>
        {{$users->links()}}
    </div>
    <div class="row">
        <a href="{{route('user.create')}}" class="my-2 btn btn-sm btn-info">{{__('Δημιουργία Χρήστη')}}</a>
        <a href="{{route('user.viewCreateUsers')}}" class="my-2 btn btn-sm btn-secondary">{{__('Δημιουργία Χρηστών')}}</a>
    </div>
@endsection
