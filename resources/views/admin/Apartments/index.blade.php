@extends('layouts.app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <!-- Begin Page Content -->
   <h1 class="mb-4">Appartamenti</h1>
   @if (Auth::user() && Auth::user()->apartments()->exists())
    <a href="{{ route('admin.apartments.create') }}" class="btn btn-admin mb-3">Crea Nuovo Appartamento</a>
    <div class="table-responsive-md">
        <table id="res-table" class="table table-hover">
            <thead>
                <tr class="r">
                    <th class="d-none d-md-table-cell">Immagine</th>
                    <th>Nome</th>
                    <th>Indirizzo</th>
                    <th class="visible">Visibile</th>
                    <th>Azione</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($apartments as $apartment)
                    <tr class="align-middle r">

                        <td class="w-25 d-none d-md-table-cell" data-title="image">
                            <img src="{{ asset('storage/' . $apartment->cover_image)}}" alt="{{$apartment->name}}"
                                style="width: 200px; height: 150px">
                        </td>
                        <td data-title="name" class="w-25">{{ $apartment->name }}</td>
                        <td data-title="name" class="w-25">{{ $apartment->address }}</td>
                        @if($apartment->visible == 1)
                            <td data-title="visible" class="visible">Si</td>
                        @else
                            <td data-title="visible" class="visible">No</td>
                        @endif
                        <td data-title="actions">
                            <a href="{{ route('admin.apartments.show', $apartment->slug) }}" class="color-admin p-2"
                                id="btnInfo"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.apartments.edit', $apartment->slug) }}" class="color-admin p-2"><i
                                    class="fas fa-pencil-alt"></i></a>
                            <form action="{{ route('admin.apartments.destroy', $apartment->slug) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <a type="button" class="color-admin p-2"><i
                                        class="fas fa-trash-alt delete-button"></i></a>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @include('admin.partials.modal-delete')
@else
    <p>Non ci sono appartamenti salvati</p>
    <a href="{{ route('admin.apartments.create') }}" class="btn btn-admin my-3">Crea Nuovo Appartamento</a>
@endif
@endsection