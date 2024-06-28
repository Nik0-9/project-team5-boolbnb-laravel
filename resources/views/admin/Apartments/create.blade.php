
@extends('layouts.app')

@section('content')
    <h1>Crea Nuovo Appartamento</h1>
    <form action="{{ route('admin.apartments.store') }}" method="POST">
        @csrf
        @include('layouts.partials.form')
        <button type="submit" class="btn btn-primary" >Salva</button>
    </form>
@endsection