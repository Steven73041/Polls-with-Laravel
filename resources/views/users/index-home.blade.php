<ul class="list-group">
    @foreach($users as $user)
        <li class="list-group-item d-flex align-items-center">
            <div class="col-sm-6">{{$user->name}}</div>
            <div class="col-sm-3">
                <span class="badge badge-primary badge-pill" title="Δημιουργήθηκε {{$user->created_at}}">{{$user->created_at}}</span>
            </div>
            <div class="col-sm-3">
                <a href="{{route('user.edit', $user->id)}}" class="btn btn-info"
                   target="_self">{{__('Επεξεργασία')}}</a>
            </div>
        </li>
    @endforeach
</ul>
@if(count($users) == 20)
    <a href="{{route('user.index')}}"
       class="my-2 btn btn-sm btn-secondary">{{__('Εμφάνιση όλων')}}</a>
@endif
<a href="{{route('user.create')}}" class="my-2 btn btn-sm btn-info">{{__('Δημιουργία Χρήστη')}}</a>
<a href="{{route('user.viewCreateUsers')}}" class="my-2 btn btn-sm btn-secondary">{{__('Δημιουργία Χρηστών')}}</a>

