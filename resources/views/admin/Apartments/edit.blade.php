
@extends('layouts.app')

@section('content')
    <h1>Modifica Appartamento</h1>
    <form action="{{ route('admin.apartments.update', $apartment->slug) }}" method="POST">
        @csrf
        @method('PUT')
        @include('layouts.partials.form')
        <button type="submit" class="btn btn-primary" >Aggiorna</button>
    </form>
@endsection