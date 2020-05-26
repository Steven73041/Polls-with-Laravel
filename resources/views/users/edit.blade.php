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
    <form action="{{route('user.update', $user->id)}}" method="POST">
        <div class="form-group">
            <label for="name">{{__('Όνομα')}}</label>
            <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}">
        </div>
        <div class="form-group">
            <label for="email">{{__('e-mail')}}</label>
            <input type="email" name="email" class="form-control" id="email" value="{{$user->email}}"/>
        </div>
        <div class="form-group">
            <label for="password">{{__('Κωδικός')}}</label>
            <input type="password" name="password" class="form-control" id="password"/>
        </div>

        <!-- if is not admin do not show roles edit, backend checked also -->
        @if (Auth::user()->role == 1)
            <div class="form-group">
                <label for="role">{{__('Ρόλος')}}</label>
                <select class="form-control" id="role" name="role" aria-describedby="roleHelp">
                    <option @if($user->role == 1) selected @endif value="1">{{__('Διαχειριστής')}}</option>
                    <option @if($user->role == 2) selected @endif value="2">{{__('Χρήστης')}}</option>
                </select>
                <small id="roleHelp"
                       class="form-text text-muted">{{__('Προσοχή! Ο διαχειριστής έχει πρόσβαση παντού.')}}</small>
            </div>
            <div class="form-group">
                <label for="send_email">{{__('Αποστολή των στοιχείων με e-mail στον χρήστη')}}</label>
                <input type="checkbox" value="1" name="send_email" id="send_email"/>
            </div>
            @if(count($categories)>0)
                <h3>{{__('Κατηγορίες')}}</h3>
                @php $i = 0; @endphp
                @foreach($categories as $category)
                    <div class="form-check">
                        <input class="form-check-input" name="categories[]" type="checkbox"
                               @if(!empty($cat_ids) && $category->id && in_array($category->id, $cat_ids)) checked
                               @endif value="{{$category->id}}"
                               id="{{$category->name}}">
                        <label class="form-check-label" for="{{$category->name}}">{{$category->name}}</label>
                    </div>
                    @php $i++; @endphp
                @endforeach
            @endif
        @endif
        @csrf
        @method('PATCH')
        <input type="submit" class="my-1 btn btn-primary" name="submit" value="{{__('Αποθήκευση')}}"/>
    </form>
    @if (Auth::user()->role == 1)
        <form method="POST" action="{{route('user.destroy', $user->id)}}">
            @method('DELETE')
            @csrf
            <input type="submit" class="my-1 btn btn-danger" value="{{__('Διαγραφή')}}" name="submit"/>
        </form>
    @endif
@endsection
