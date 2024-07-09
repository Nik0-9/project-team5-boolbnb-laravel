@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
   <h1 class="mb-4">Appartamenti</h1>
   @if (Auth::user() && Auth::user()->apartments()->exists())
    <a href="{{ route('admin.apartments.create') }}" class="btn btn-primary mb-3">Crea Nuovo Appartamento</a>
    <div class="table-responsive-md">
    <table id="res-table" class="table table-hover">
        <thead>
            <tr class="r">
                <th>Nome</th>
                <th>Immagine</th>
                <th class="address">Indirizzo</th>
                <th class="visible">Visibile</th>
                <th>Azione</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($apartments as $apartment)
                <tr class="align-middle r">
                    
                    <td data-title="name" class="w-25">{{ $apartment->name }}</td>
                    <td class="w-25" data-title="image"><img class="w-50" src="{{ asset('storage/' . $apartment->cover_image)}}" alt="{{$apartment->name}}"></td>
                    <td data-title="address" class="w-25">{{ $apartment->address }}</td>
                    @if($apartment->visible == 1)
                    <td data-title="visible" class="visible">Si</td>
                    @else
                    <td data-title="visible" class="visible">No</td>
                    @endif
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
    @else
     <p>non hai ancora alcun appartamento</p>
     <a href="{{ route('admin.apartments.create') }}" class="btn btn-primary my-3">Crea Nuovo Appartamento</a>
     @endelse
     @endif

@endsection
