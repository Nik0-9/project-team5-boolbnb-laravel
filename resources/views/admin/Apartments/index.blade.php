@extends('layouts.app')

@section('content')
    <h1>Appartamenti</h1>
    <a href="{{ route('admin.apartments.create') }}" class="btn btn-primary">Crea Nuovo Appartamento</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Indirizzo</th>
                <th>Azione</th>
            </tr>
        </thead>
        <tbody>
            @foreach($apartments as $apartment)
                <tr>
                    <td>{{ $apartment->id }}</td>
                    <td>{{ $apartment->name }}</td>
                    <td>{{ $apartment->address }}</td>
                    <td>
                        <a href="{{ route('admin.apartments.show', $apartment->slug) }}" class="btn btn-info"><i class="fa-solid fa-eye"></i></a>
                        <a href="{{ route('admin.apartments.edit', $apartment->slug) }}" class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a>
                        <form action="{{ route('admin.apartments.destroy', $apartment->slug) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i><i class="fas fa-trash-alt"></i></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection