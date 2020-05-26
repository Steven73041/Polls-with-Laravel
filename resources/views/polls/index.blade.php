@extends('layouts.app')
@section('content')
    <div class="row">
        <ul class="list-group">
            @foreach($polls as $poll)
                <li class="list-group-item">{{$poll->question}}
                    <span class="badge badge-primary badge-pill">{{count($poll->votes)}}</span>
                    <a href="{{route('poll.edit', $poll->id)}}" class="btn btn-info"
                       target="_self">{{__('Επεξεργασία')}}</a></li>
            @endforeach
        </ul>
        {{$polls->links()}}
    </div>
    <div class="row">
        <a href="{{route('poll.create')}}" class="my-2 btn btn-sm btn-info">{{__('Δημιουργία Ερώτησης')}}</a>
    </div>
@endsection
