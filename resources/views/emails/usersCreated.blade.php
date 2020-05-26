<html>
<body>
<h3>Hello, <a href="{{route('home')}}" target="_new">Login Here</a></h3>
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
