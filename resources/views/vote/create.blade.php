@extends('layouts.app')
@section('content')
    @foreach ($category->polls as $poll)
        @if (user_has_voted_this($poll->id))
            @php continue; @endphp
        @endif
        <div class="card">
            <div class="card-header">
                {{$poll->question}}
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('vote.store')}}">
                    <div class="form-group">
                        <input class="form-control" type="text" name="answer[]" id="answer-{{$poll->id}}" required/>
                    </div>
                    <button class="btn btn-secondary add" title="{{__('Προσθήκη απάντησης')}}">+</button>
                    <button class="delete btn btn-danger" title="{{__('Αφαίρεση απάντησης')}}">-</button>
                    <input type="hidden" name="poll_id" value="{{$poll->id}}"/>
                    @csrf
                    <input class="btn btn-primary" type="submit" name="submit" value="{{__('Αποστολή')}}"/>
                </form>
            </div>
        </div>
    @endforeach
@endsection
