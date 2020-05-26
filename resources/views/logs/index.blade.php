@extends('layouts.app')
@section('content')
    <div class="row">
        <table class="table">
            <thead>
            <tr>
                <th>{{__('Ενέργεια')}}</th>
                <th>{{__('Χρήστης')}}</th>
                <th>{{__('Ημερομηνία')}}</th>
            </tr>
            </thead>
            @foreach($logs as $log)
                <tr scope="row">{{$log->question}}
                    <td>{{$log->action}}</td>
                    <td>{{$log->user->name}}</td>
                    <td>{{$log->created_at}}</td>
                </tr>
            @endforeach
        </table>
        {{$logs->links()}}
    </div>
@endsection
