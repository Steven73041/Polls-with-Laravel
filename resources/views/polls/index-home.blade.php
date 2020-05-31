<ul class="list-group">
    @foreach($polls as $poll)
        <li class="list-group-item d-flex align-items-center">
            <div class="col-sm-8">{{$poll->question}}</div>
            <div class="col-sm-1">
                <span class="badge badge-primary badge-pill"
                      title="{{count($poll->votes)}} Ψήφοι">{{count($poll->votes)}}</span>
            </div>
            <div class="col-sm-3">
                <a href="{{route('poll.edit', $poll->id)}}" class="btn btn-info"
                   target="_self">{{__('Επεξεργασία')}}</a>
            </div>
        </li>
    @endforeach
</ul>

@if(count($polls) == 20)
    <a href="{{route('poll.index')}}" class="my-2 btn btn-sm btn-info">{{__('Εμφάνιση όλων')}}</a>
@endif
<a href="{{route('poll.create')}}" class="my-2 btn btn-sm btn-info">{{__('Δημιουργία Ερώτησης')}}</a>

