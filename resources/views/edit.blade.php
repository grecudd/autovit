@extends('app')

@section('content')
    <form action="{{ route('update', $car->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <label for="brand">Brand: </label>
        <input type="text" name="brand" value="{{ $car->carModel->brand->name }}">
        <br>

        <label for="model">Model: </label>
        <input type="text" name="model" value="{{ $car->carModel->name }}">
        <br>

        <label for="gen">An fabricatie: </label>
        <input type="text" name="gen" value="{{ $car->gen }}">
        <br>

        <label for="hp">Putere: </label>
        <input type="text" name="hp" value="{{ $car->hp }}">
        <br>

        <label for="km">Km: </label>
        <input type="text" name="km" value="{{ $car->km }}">
        <br>

        <label for="price">Pret: </label>
        <input type="text" name="price" value="{{ $car->price }}">
        <br>

        <label for="fuel">Combustibil: </label>
        <input type="text" name="fuel" value="{{ $car->fuel }}">
        <br>

        <input type="file" name="image">
        <br>
        <button type="submit">Save</button>
    </form>
@endsection
