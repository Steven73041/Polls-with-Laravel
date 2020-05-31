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
    @if (count($errors->success) > 0)
        <div class="alert alert-success">
            <ul>
                @foreach ($errors->success->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form class="mb-3" method="POST" action="{{route('category.update', $category->id)}}">
        <label for="category">{{__('Κατηγορία')}}</label>
        <input type="text" name="name" class="form-control" required value="{{$category->name}}" id="category"/>
        @method('PATCH')
        @csrf
        <input type="submit" class="my-1 btn btn-primary" name="submit" value="{{__('Αποθήκευση')}}"/>
    </form>
    <a class="mb-3 btn btn-secondary" href="{{route('category.create')}}">{{__('Δημιουργία')}}</a>
    <form class="mb-3" method="POST" action="{{route('category.destroy', $category->id)}}">
        @method('DELETE')
        @csrf
        <input type="submit" class="btn btn-danger" value="{{__('Διαγραφή')}}" name="submit"/>
    </form>

    <a class="btn btn-secondary mb-3" href="javascript:history.back()">{{__('Πίσω')}}</a>

    @if($category->polls)
        <table class="table mb-3">
            <thead>
            <tr>
                <th scope="col">{{__('Ερώτηση')}}</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($category->polls as $poll)
                <tr>
                    <td>{{$poll->question}}</td>
                    <td><a class="btn btn-info" href="{{route('poll.edit', $poll->id)}}">{{__('Επεξεργασία')}}</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
