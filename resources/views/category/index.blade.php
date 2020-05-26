@extends('layouts.app')
@section('content')
    <div class="row">
        <ul class="list-group">
            @foreach($categories as $category)
                <li class="list-group-item">{{$category['name']}}
                    <span class="badge badge-primary badge-pill">{{count($category->polls)}}</span>
                    <a href="{{route('category.edit', $category->id)}}" class="btn btn-info"
                       target="_self">{{__('Επεξεργασία')}}</a></li>
            @endforeach
        </ul>
        {{$categories->links()}}
    </div>
    @if(auth()->user()->role == 1)
        <div class="row">
            <a href="{{route('category.create')}}" class="my-2 btn btn-sm btn-info">{{__('Δημιουργία Κατηγορίας')}}</a>
        </div>
    @endif
@endsection
