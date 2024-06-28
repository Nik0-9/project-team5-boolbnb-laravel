
@extends('layouts.app')

@section('content')
    <h1>Modifica Appartamento</h1>
    <form action="{{ route('apartments.update', $apartment->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('apartments.partials.form')
        <button type="submit" class="btn btn-primary">Aggiorna</button>
    </form>
@endsection