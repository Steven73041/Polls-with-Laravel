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
    <form method="POST" action="{{route('poll.update', $poll->id)}}">
        <label for="question">{{__('Ερώτηση')}}</label>
        <input type="text" name="question" class="form-control" value="{{$poll->question}}" id="question" required/>
        <select name="category_id" class="form-control" required>
            @foreach($categories as $category)
                <option @if($poll->category_id == $category->id) selected
                        @endif value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
        @csrf
        @method('PATCH')
        <input type="submit" class="my-3 btn btn-primary" name="submit" value="{{__('Αποθήκευση')}}"/>
    </form>

    <form method="POST" class="mb-3" action="{{route('poll.destroy', $poll->id)}}">
        @method('DELETE')
        @csrf
        <input type="submit" class="btn btn-danger" name="submit" value="{{__('Διαγραφή')}}"/>
    </form>

    <a class="btn btn-secondary" href="javascript:history.back()">{{__('Πίσω')}}</a>

    @if(count($poll->votes))
        <div class="row">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">{{__('Απάντηση')}}</th>
                    <th scope="col">{{__('Ημερομηνία')}}</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($poll->votes as $vote)
                    <tr>
                        <td>{{$vote->answer}}</td>
                        <td>{{$vote->created_at}}</td>
                        <td><a class="btn btn-info" href="{{route('vote.edit', $vote->id)}}">{{__('Επεξεργασία')}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if(count($poll->votes)>0)
            <div class="row">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">{{__('Απάντηση')}}</th>
                        <th scope="col">{{__('Ψήφοι')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($poll->votes()->groupBy('answer')->get('answer') as $voted)
                        <tr>
                            <td>{{$voted->answer}}</td>
                            <td>{{count(DB::table('votes')->where('answer', $voted->answer)->get())}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif
@endsection
