@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card-header">{{__('Δημιουργία χρηστών')}}</div>
                    <form class="form" id="create_users" action="{{route('createUsers')}}" method="post">
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label for="">{{__('Εισάγεται τα e-mails')}}</label>
                                <input type="email" name="email[]" class="form-control mb-3" placeholder="email"/>
                                <button class="btn btn-secondary add" title="{{__('Προσθήκη email')}}">+</button>
                                <button class="delete btn btn-danger" title="{{__('Αφαίρεση email')}}">-</button>
                            </div>
                            <div class="col-sm-6">
                                <label for="exampleFormControlSelect2">{{__('Κατηγορίες')}}</label>
                                @if(!empty($categories))
                                    <select multiple class="form-control" id="exampleFormControlSelect2" required>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                        @csrf
                        <input type="submit" name="submit" class="btn btn-primary" value="{{__('Δημιουργία')}}"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
