<div class="row">
    <ul class="list-group">
        @foreach($users as $user)
            <li class="list-group-item d-flex justify-content-between align-items-center">{{$user['name']}}
                <span class="badge badge-primary badge-pill">{{$user->created_at}}</span>
                <a href="{{route('user.edit', $user->id)}}" class="btn btn-info"
                   target="_self">{{__('Επεξεργασία')}}</a></li>
        @endforeach
    </ul>
</div>
<div class="">
    @if(count($users) == 20)
        <a href="{{route('user.index')}}"
           class="my-2 btn btn-sm btn-secondary">{{__('Εμφάνιση όλων')}}</a>
    @endif
    <a href="{{route('user.create')}}" class="my-2 btn btn-sm btn-info">{{__('Δημιουργία Χρήστη')}}</a>
    <a href="{{route('user.viewCreateUsers')}}" class="my-2 btn btn-sm btn-secondary">{{__('Δημιουργία Χρηστών')}}</a>
</div>
