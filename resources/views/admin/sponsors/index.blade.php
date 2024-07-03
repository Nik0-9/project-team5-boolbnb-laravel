@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
   <h1>Sponsorizzazioni</h1>
    <a href="{{ route('admin.sponsors.create') }}" class="btn btn-primary">Crea Nuova Sponsorizzazione</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Prezzo</th>
                <th>Durata</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($apartments as $apartment )           
            @foreach ($apartment->sponsor as $sponsor)
                <tr>
                    <td>{{ $sponsor->id }}</td>
                    <td>{{ $sponsor->name }}</td>
                    <td>{{ $sponsor->price }}</td>
                    <td>{{ $sponsor->duration }}</td>

                    <td>
                         <a href="{{ route('admin.sponsors.show', $sponsor->name) }}" class="btn btn-info" id="btnInfo"><i
                                class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.sponsors.edit', $sponsor->name) }}" class="btn btn-warning"><i
                                class="fas fa-pencil-alt"></i></a>
                        <form action="{{ route('admin.sponsors.destroy', $sponsor->name) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-button"><i><i
                                        class="fas fa-trash-alt"></i></i></button>
                        </form> 
                    </td>
                </tr>
            @endforeach
            @endforeach
        </tbody>
    </table>
    @include('admin.partials.modal-delete')
@endsection
