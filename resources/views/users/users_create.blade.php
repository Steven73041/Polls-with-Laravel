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
                                <label for="email">{{__('Εισάγεται τα e-mails και τα ονόματα των χρηστών')}}</label>
                                <input type="email" id="email" name="email[]" class="form-control mb-3" placeholder="email"/>
                                <input type="text" name="name[]" class="form-control mb-3" placeholder="Ονοματεπώνυμο"/>
                                <button class="btn btn-secondary add" title="{{__('Προσθήκη email')}}">+</button>
                                <button class="delete btn btn-danger" title="{{__('Αφαίρεση email')}}">-</button>
                            </div>
                            <div class="col-sm-6">
                                <label for="categories">{{__('Κατηγορίες')}}</label>
                                @if(!empty($categories))
                                    <select multiple class="form-control" id="categories" required>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    <button style="position: absolute; right: 15px; top: -5px;" type="button" class="btn btn-info" data-toggle="tooltip" data-html="true"
                                            title="Με το πάτημα του <code>CTRL</code> μπορείτε να επιλέξετε <b>πολλές</b> επιλογές">
                                        ?
                                    </button>
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
