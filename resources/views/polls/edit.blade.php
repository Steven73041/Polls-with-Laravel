@extends('layouts.app')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (count($errors->success) > 0)
        <div class="alert alert-success">
            <ul>
                @foreach ($errors->success->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Edit Poll -->
    <form method="POST" action="{{route('poll.update', $poll->id)}}">
        <label for="question">{{__('Ερώτηση')}}</label>
        <input type="text" name="question" class="form-control mb-3" value="{{$poll->question}}" id="question"
               required/>
        <label for="category_id">{{__('Κατηγορία')}}</label>
        <select name="category_id" id="category_id" class="form-control" required>
            @foreach($categories as $category)
                <option @if($poll->category_id == $category->id) selected
                        @endif value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
        @csrf
        @method('PATCH')
        <input type="submit" class="my-3 btn btn-primary" name="submit" value="{{__('Αποθήκευση')}}"/>
    </form>

    <!-- Close Poll -->
    <form method="POST" class="mb-3" action="{{route('TogglePoll')}}"
          @if(!$poll->isClosed) onsubmit="return confirm('Είστε σίγουροι ότι θέλετε να κλείσετε την ερώτηση και να σταλεί e-mail σε όλους με τα αποτελέσματα;');"@endif>
        @method('PATCH')
        @csrf
        <input type="hidden" name="id" value="{{$poll->id}}"/>
        <input type="hidden" name="isClosed" value="{{($poll->isClosed?0:1)}}"/>
        <input type="submit" class="btn btn-outline-{{($poll->isClosed?'info':'danger')}}" name="submit"
               value="{{($poll->isClosed?__('Άνοιγμα Ερώτησης'):__('Κλείσιμο Ερώτησης'))}}"/>
        @if(!$poll->isClosed)
            <button type="button" data-toggle="tooltip" data-html="true"
                    title="Με το κλείσιμο της ερώτησης, θα σταλεί e-mail με τα αποτελέσματα σε <b>όλους</b> του ψηφοφόρους">
                ?
            </button>
        @endif
    </form>

    <!-- Delete Poll -->
    <form method="POST" class="mb-3" action="{{route('poll.destroy', $poll->id)}}">
        @method('DELETE')
        @csrf
        <input type="submit" class="btn btn-danger" name="submit" value="{{__('Διαγραφή')}}"/>
    </form>

    <a class="btn btn-secondary mb-3" href="javascript:history.back()">{{__('Πίσω')}}</a>

    @if(count($poll->votes))
        <div class="row">
            <div class="col">
                <table class="table mb-3">
                    <thead>
                    <tr>
                        <th scope="col">{{__('Απάντηση')}}</th>
                        <th scope="col">{{__('Ημερομηνία')}}</th>
                        <th scope="col">
                            @if($poll->isClosed)
                                <button type="button" data-toggle="tooltip" data-html="true"
                                        title="{{__('Η επεξεργασία δεν είναι δυνατή σε κλειστή ψηφοφορία καθώς τα αποτελέσματα έχουν καθοριστεί')}}">
                                    ?
                                </button>
                            @endif
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($poll->votes as $vote)
                        <tr>
                            <td>{{$vote->answer}}</td>
                            <td>{{$vote->created_at}}</td>
                            <td>
                                @if(!$poll->isClosed)
                                    <a class="btn btn-info"
                                       href="{{route('vote.edit', $vote->id)}}">{{__('Επεξεργασία')}}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="card m-auto">
                <canvas id="voteChart" width="400" height="400" aria-label="Ψήφοι" role="img"></canvas>
            </div>
            <script>
                let ctx = 'voteChart';
                let labels = [];
                let votes = [];
                @foreach($poll->votes()->groupBy('answer')->get('answer') as $voted)
                labels.push('{{$voted->answer}}');
                votes.push('{{count(DB::table('votes')->where('answer', $voted->answer)->get())}}');
                    @endforeach
                var myChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: '# ψήφοι',
                                data: votes,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            legend: {
                                position: 'bottom',
                                display: true,
                                labels: {
                                    generateLabels: function (chart) {
                                        var data = chart.data;
                                        if (data.labels.length && data.datasets.length) {
                                            return data.labels.map(function (label, i) {
                                                var meta = chart.getDatasetMeta(0);
                                                var ds = data.datasets[0];
                                                var arc = meta.data[i];
                                                var custom = arc && arc.custom || {};
                                                var getValueAtIndexOrDefault = Chart.helpers.getValueAtIndexOrDefault;
                                                var arcOpts = chart.options.elements.arc;
                                                var fill = custom.backgroundColor ? custom.backgroundColor : getValueAtIndexOrDefault(ds.backgroundColor, i, arcOpts.backgroundColor);
                                                var stroke = custom.borderColor ? custom.borderColor : getValueAtIndexOrDefault(ds.borderColor, i, arcOpts.borderColor);
                                                var bw = custom.borderWidth ? custom.borderWidth : getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts.borderWidth);

                                                // We get the value of the current label
                                                var value = chart.config.data.datasets[arc._datasetIndex].data[arc._index];

                                                return {
                                                    // Instead of `text: label,`
                                                    // We add the value to the string
                                                    text: "Απάντηση: " + label + " Ψήφοι: " + value,
                                                    fillStyle: fill,
                                                    strokeStyle: stroke,
                                                    lineWidth: bw,
                                                    hidden: isNaN(ds.data[i]) || meta.data[i].hidden,
                                                    index: i
                                                };
                                            });
                                        } else {
                                            return [];
                                        }
                                    }
                                }
                            },
                            responsive: true,
                            title: {
                                display: true,
                                text: "Συνολικά {{count($poll->votes)}} ψήφοι"
                            },
                        }
                    });
            </script>
        </div>
    @endif
@endsection
