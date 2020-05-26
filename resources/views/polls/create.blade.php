@extends('layouts.app')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (count($errors->success) > 0)
        <div class="alert alert-success">
            <ul>
                @foreach ($errors->success->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form class="form-group" method="POST" action="{{route('poll.store')}}">
        <input type="text" name="question" class="form-control" required/>
        @if(count($categories) > 0)
            <select name="category_id" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        @endif
        @csrf
        <input type="submit" class="btn btn-primary" name="submit" value="{{__('Αποθήκευση')}}"/>
    </form>
@endsection
