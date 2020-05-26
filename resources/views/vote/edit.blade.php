@extends('layouts.app')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (count($errors->success)>0)
        <div class="alert alert-success">
            <ul>
                @foreach ($errors->success->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{route('vote.update', $vote->id)}}" method="POST">
        <label for="answer">{{__('Απάντηση')}}</label>
        <input class="form-control" type="text" name="answer" value="{{$vote->answer}}" required id="answer"/>
        @csrf
        @method('PATCH')
        <input class="mt-2 btn btn-primary" name="submit" type="submit" value="{{__('Αποθήκευση')}}"/>
    </form>
    <a class="btn btn-secondary" href="javascript:history.back()">{{__('Πίσω')}}</a>
@endsection
