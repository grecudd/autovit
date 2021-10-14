@extends('app')

@section('content')

    <h3 style="color: green">
        @if (session('car_deleted'))
            {{ session('car_deleted') }}
        @endif
        @if (session('car_avalability'))
            {{ session('car_avalability') }}
        @endif
        @if (session('buy_validated'))
            {{ session('buy_validated') }}
        @endif
    </h3>
    <h3>
        @if (session('buy_error'))
            {{ session('buy_error') }}
        @endif
    </h3>

    <h2>{{ Auth::user()->name }}</h2>
    <h2>
        <form action="{{ route('cars.create') }}">
            <input type="submit" value="Add car">
        </form>
    </h2>

    <h2>Balance: {{ Auth::user()->balance }} $</h2>

    <h2>Owned Cars</h2>
    <h3>
        @if (count($cars) > 0)
            @foreach ($cars as $car)
                <a href="{{ route('cars.show', $car->id) }}">{{ $car->carModel->brand->name }}
                    {{ $car->carModel->name }}
                </a>
                <br>
            @endforeach
        @else No cars owned.
        @endif

    </h3>

    <h2>Listed Cars</h2>
    <h3>
        @if (count($listedCars) > 0)
            @foreach ($listedCars as $car)
                <a href="{{ route('cars.show', $car->id) }}">{{ $car->carModel->brand->name }}
                    {{ $car->carModel->name }}
                </a>
                <br>
            @endforeach
        @else No cars listed.
        @endif
    </h3>
@endsection
