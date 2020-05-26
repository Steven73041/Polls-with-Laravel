@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-header">
                {{$poll->question}}
            </div>
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
@endsection
