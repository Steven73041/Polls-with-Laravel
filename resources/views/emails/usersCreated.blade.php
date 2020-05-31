<html lang="el">
<body>
<h3>{{__('Γεια σου ').$user->name.__(' Συνδέσου')}} <a href="{{route('home')}}" target="_new">{{'εδώ'}}</a></h3>
<table class="table">
    <tr>
        <th>{{__('Username')}}</th>
        <th>{{__('Password')}}</th>
    </tr>
    <tr>
        <td>{{$user->email}}</td>
        <td>{{$password}}</td>
    </tr>
</table>
</body>
</html>
