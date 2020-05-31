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
    <form class="form-group" method="POST" action="{{route('category.store')}}">
        <label for="category">{{__('Κατηγορία')}}</label>
        <input type="text" name="name" class="form-control" required id="category"/>
        @csrf
        <input type="submit" class="btn btn-primary mt-3" name="submit" value="{{__('Αποθήκευση')}}"/>
    </form>
    <a class="btn btn-secondary" href="javascript:history.back()">{{__('Πίσω')}}</a>
@endsection
