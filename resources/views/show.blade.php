@extends('app')

@section('content')
    <h3 style="color: green">
        @if (session('car_update'))
                {{ session('car_update') }}
        @endif
    </h3>
    <h2>
        {{ $car->carModel->brand->name }} {{ $car->carModel->name }}
    </h2>
    @if (Auth::user() && ($car->user_id == Auth::user()->id || $car->bought_user_id == Auth::user()->id))
        <form action="{{ route('cars.destroy', $car->id) }}" method="POST">
            @method('DELETE')
            @csrf
            <button type="submit">Delete</button>
        </form>

        <form action="{{ route('cars.edit', $car->id) }}" method="GET">
            @csrf
            <button type="submit">Edit</button>
        </form>

    @elseif ($car->bought_user_id==null)
        <form action="{{ route('cars.buy', $car->id) }}" method="GET">
            @csrf
            <button type="submit">Buy</button>
        </form>
    @endif

    @if ($car->image_path != 'null')
        <img src="{{ asset('images/' . $car->image_path) }}" width="500" height="300">
    @endif


    <h3>
        Generatia: {{ $car->gen }} <br>
        Putere: {{ $car->hp }} cp <br>
        Km: {{ $car->km }} <br>
        Pret: {{ $car->price }} $ <br>
        Combustibil: {{ $car->fuel }} <br>
        @if (Auth::user())
            @if ($car->user_id == Auth::user()->id)
                @if ($car->avalability == false)
                    <form action="{{ route('cars.list', $car->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <input type="submit" value="List">
                    </form>
                @else
                    <form action="{{ route('cars.list', $car->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <input type="submit" value="Remove">
                    </form>
                @endif
            @endif
        @endif
    </h3>

@endsection
