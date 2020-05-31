<ul class="list-group">
    @foreach($categories as $category)
        @if((user_voted_category($category->id) || !$category->polls) && auth()->user()->role == 2 )
            @php continue; @endphp
        @endif
        <li class="list-group-item d-flex align-items-center">
            <div class="col-sm-7">{{$category->name}}</div>
            <div class="col-sm-2">
                <span class="badge badge-primary badge-pill" title="Αριθμός ερωτήσεων: {{count($category->polls)}}">{{count($category->polls)}}</span>
            </div>
            <div class="col-sm-3">
                @if(auth()->user()->role == 1)
                    <a href="{{route('category.edit', $category->id)}}" class="btn btn-info"
                       target="_self">{{__('Επεξεργασία')}}</a>
                @else
                    <a href="{{route('vote.voting', $category->id)}}" class="btn btn-info"
                       target="_self">{{__('Ερωτήσεις')}}</a>
                @endif
            </div>
        </li>
    @endforeach
</ul>

@if(count($categories) == 20)
    <a href="{{route('category.index')}}" class="my-2 btn btn-sm btn-info">{{__('Εμφάνιση όλων')}}</a>
@endif
@if(auth()->user()->role == 1)
    <a href="{{route('category.create')}}" class="my-2 btn btn-sm btn-info">{{__('Δημιουργία Κατηγορίας')}}</a>
@endif
