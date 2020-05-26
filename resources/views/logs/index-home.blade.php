<div class="row">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">{{__('Ενέργεια')}}</th>
            <th scope="col">{{__('Χρήστης')}}</th>
            <th scope="col">{{__('Ημερομηνία')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($logs as $log)
            <tr>
                <td>{{$log->action}}</td>
                <td>{{$log->user->name}}</td>
                <td>{{$log->created_at}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@if(count($logs) == 20)
    <div class="row">
        <a href="{{route('log.index')}}" class="my-2 btn btn-sm btn-info">{{__('Εμφάνιση όλων')}}</a>
    </div>
@endif
