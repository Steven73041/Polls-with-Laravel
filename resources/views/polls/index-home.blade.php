<div class="row">
    <ul class="list-group">
        @foreach($polls as $poll)
            <li class="list-group-item d-flex justify-content-between align-items-center">{{$poll->question}}
                <span class="badge badge-primary badge-pill">{{count($poll->votes)}}</span>
                <a href="{{route('poll.edit', $poll->id)}}" class="btn btn-info"
                   target="_self">{{__('Επεξεργασία')}}</a></li>
        @endforeach
    </ul>
</div>
<div class="row">
    @if(count($polls) == 20)
        <a href="{{route('poll.index')}}" class="my-2 btn btn-sm btn-info">{{__('Εμφάνιση όλων')}}</a>
    @endif
    <a href="{{route('poll.create')}}" class="my-2 btn btn-sm btn-info">{{__('Δημιουργία Ερώτησης')}}</a>
</div>
