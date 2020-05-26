<div class="row">
    <ul class="list-group">
        @foreach($categories as $category)
            @if((user_voted_category($category->id) || !$category->polls) && auth()->user()->role == 2 )
                @php continue; @endphp
            @endif
            <li class="list-group-item d-flex justify-content-between align-items-center">{{$category['name']}}
                <span class="badge badge-primary badge-pill">{{count($category->polls)}}</span>
                @if(auth()->user()->role == 1)
                    <a href="{{route('category.edit', $category->id)}}" class="btn btn-info"
                       target="_self">{{__('Επεξεργασία')}}</a>
                @else
                    <a href="{{route('vote.voting', $category->id)}}" class="btn btn-info"
                       target="_self">{{__('Ερωτήσεις')}}</a>
                @endif
            </li>
        @endforeach
    </ul>
</div>
<div class="row">
    @if(count($categories) == 20)
        <a href="{{route('category.index')}}" class="my-2 btn btn-sm btn-info">{{__('Εμφάνιση όλων')}}</a>
    @endif
    @if(auth()->user()->role == 1)
        <a href="{{route('category.create')}}" class="my-2 btn btn-sm btn-info">{{__('Δημιουργία Κατηγορίας')}}</a>
    @endif
</div>
