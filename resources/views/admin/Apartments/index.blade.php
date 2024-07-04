@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
   <h1>Appartamenti</h1>
    <a href="{{ route('admin.apartments.create') }}" class="btn btn-primary">Crea Nuovo Appartamento</a>
    <div class="table-responsive-md">
    <table id="res-table" class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th class="address">Indirizzo</th>
                <th>Azione</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($apartments as $apartment)
                <tr>
                    <td data-title="id">{{ $apartment->id }}</td>
                    <td data-title="name">{{ $apartment->name }}</td>

                    <td data-title="address" class="address">{{ $apartment->address }}</td>
                    <td data-title="actions">
                        <a href="{{ route('admin.apartments.show', $apartment->slug) }}" class="btn btn-info" id="btnInfo"><i
                                class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.apartments.edit', $apartment->slug) }}" class="btn btn-warning"><i
                                class="fas fa-pencil-alt"></i></a>
                        <form action="{{ route('admin.apartments.destroy', $apartment->slug) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-button"><i><i
                                        class="fas fa-trash-alt"></i></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>

    @include('admin.partials.modal-delete')
@endsection
