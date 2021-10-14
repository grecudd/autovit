@extends('app')

@section('content')
    <h3 style="color: green">
        @if (session('car_added'))
                {{ session('car_added') }}
        @endif
    </h3>

    <h1>Cars</h1>
    <h3>

        <form action="{{ route('cars.index') }}" method="GET">
            @csrf
            <label for="brand">Brand</label>
            <input type="text" name="brand">
            <br>

            <label for="model">Model</label>
            <input type="text" name="model">
            <br>

            <label for="kmMin">Km</label>
            <input type="text" name="kmMin">
            <label for="kmMax"></label>
            <input type="text" name="kmMax">
            <br>

            <label for="priceMin">Pret</label>
            <input type="text" name="priceMin">
            <label for="priceMax"></label>
            <input type="text" name="priceMax">
            <br>

            <label for="genMin">An</label>
            <input type="text" name="genMin">
            <label for="genMax"></label>
            <input type="text" name="genMax">
            <br>

            <button type="submit">Search</button>
        </form>

        <br>{{ count($cars) }} rezultate <br><br>

        @if (count($cars) > 0)
            @foreach ($cars as $car)
                @if ($car->avalability)
                    <a href="{{ route('cars.show', $car->id) }}">
                        @if ($car->image_path != 'null')
                            <img src="{{ asset('images/' . $car->image_path) }}" width="150" height="90">
                        @endif
                        {{ $car->carModel->brand->name }} {{ $car->carModel->name }} {{ $car->price }} $
                        <br>
                    </a>
                    <br>
                @endif
            @endforeach
        @endif
    </h3>
@endsection
