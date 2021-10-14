<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $_SERVER['APP_NAME'] }}</title>
</head>

<body>
    <h3>
        <a href="{{ route('cars.index') }}">Autovit </a>
        @if (!Auth::user())
            <a href="{{ route('login') }}"> / LogIn </a>
        @else
            / User : {{ Auth::user()->name }} /
            <a href="{{ route('cars.dashboard') }}">Dashboard /</a>
            <a href="{{ route('logOut') }}">LogOut</a>
        @endif

    </h3>

    @yield('content')
</body>

</html>
