@extends('app')

@section('content')
    <h2>
        {{ Auth::user()->name }} <br>
        Balance: {{ Auth::user()->balance }} $
        <form action="{{ route('cars.validateBuy', $car->id) }}">
            <button type="submit">Yes</button>
        </form>
        <form action="{{ route('cars.show', $car->id) }}">
            <button type="submit">No</button>
        </form>
    </h2>
@endsection
