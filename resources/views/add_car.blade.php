@extends('app')

@section('content')
    <h3>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <li style="color: red">
                    {{ $error }}
                </li>
            @endforeach
        @endif
    </h3>
    <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="brand">Brand: </label>
        <input type="text" name="brand">
        <br>

        <label for="model">Model: </label>
        <input type="text" name="model">
        <br>

        <label for="gen">An fabricatie: </label>
        <input type="text" name="gen">
        <br>

        <label for="hp">Putere: </label>
        <input type="text" name="hp">
        <br>

        <label for="km">Km: </label>
        <input type="text" name="km">
        <br>

        <label for="price">Pret: </label>
        <input type="text" name="price">
        <br>

        <label for="fuel">Combustibil: </label>
        <input type="text" name="fuel">
        <br>

        <input type="file" name="image">
        <br>
        <button type="submit">Add</button>
    </form>
@endsection
