@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">{{__('Καλώς Όρισες!')}}</div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="list-group" id="list-tab" role="tablist">
                        @if(!user_voted_categories())
                            <a class="list-group-item list-group-item-action active" id="list-categories-list"
                               data-toggle="list" href="#list-categories" role="tab"
                               aria-controls="categories">{{__('Οι Κατηγορίες μου')}}
                                <span class="badge badge-primary badge-pill">{{count($categories)}}</span></a>
                        @endif
                        @if(count($logs) > 0)
                            <a class="list-group-item list-group-item-action" id="list-logs-list"
                               data-toggle="list" href="#list-logs" role="tab"
                               aria-controls="logs">{{__('Το Ιστορικό μου')}}
                                <span class="badge badge-primary badge-pill">{{count($logs)}}</span></a>
                        @endif
                    </div>
                </div>
                <div class="col-8">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="list-categories" role="tabpanel"
                             aria-labelledby="list-categories-list">@include('category.index-home')</div>
                        @if(count($logs) > 0)
                            <div class="tab-pane fade" id="list-logs" role="tabpanel"
                                 aria-labelledby="list-polls-list">@include('logs.index-home')</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
