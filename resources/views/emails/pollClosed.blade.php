<html lang="el">
<head>
    <title>{{__('Αποτελέσματα ερώητησης: ').$poll->question}}</title>
</head>
<body>
<h3>{{__('Αγαπητέ ').$user->name}}</h3>
<h4>{{__('Παρακάτω τα αποτελέσματα της ψηφοφορίας στην ερώητηση: ').$poll->question}}</h4>
<table class="table mb-3">
    <thead>
    <tr>
        <th scope="col">{{__('Απάντηση')}}</th>
        <th scope="col">{{__('Ψήφοι')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($poll->votes()->groupBy('answer')->get('answer') as $vote)
        <tr>
            <td>{{$vote->answer}}</td>
            <td>{{count(DB::table('votes')->where('answer', $vote->answer)->get())}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
