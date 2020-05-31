@extends('layouts.app')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header text-center">{{__('Διαχειριστικό')}}</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="list-group" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action active" id="list-categories-list"
                               data-toggle="list" href="#list-categories" role="tab" aria-controls="categories">{{__('Κατηγορίες')}}
                                <span class="badge badge-primary badge-pill">{{$categories_count}}</span>
                            </a>
                            <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list"
                               href="#list-users" role="tab" aria-controls="users">{{__('Χρήστες')}}
                                <span class="badge badge-primary badge-pill">{{$users_count}}</span>
                            </a>
                            <a class="list-group-item list-group-item-action" id="list-polls-list" data-toggle="list"
                               href="#list-polls" role="tab" aria-controls="polls">{{__('Ερωτήσεις')}}
                                <span class="badge badge-primary badge-pill">{{$polls_count}}</span>
                            </a>
                            @if(count($logs) > 0)
                                <a class="list-group-item list-group-item-action" id="list-logs-list" data-toggle="list"
                                   href="#list-logs" role="tab" aria-controls="logs">{{__('Ιστορικό')}}
                                    <span class="badge badge-primary badge-pill">{{$logs_count}}</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="list-categories" role="tabpanel"
                                 aria-labelledby="list-categories-list">@include('category.index-home')</div>
                            <div class="tab-pane fade" id="list-users" role="tabpanel"
                                 aria-labelledby="list-users-list">@include('users.index-home')</div>
                            <div class="tab-pane fade" id="list-polls" role="tabpanel"
                                 aria-labelledby="list-polls-list">@include('polls.index-home')</div>
                            @if(count($logs) > 0)
                                <div class="tab-pane fade" id="list-logs" role="tabpanel"
                                     aria-labelledby="list-polls-list">@include('logs.index-home')</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
