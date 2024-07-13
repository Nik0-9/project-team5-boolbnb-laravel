@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <h1 class="mb-4">Appartamenti</h1>
    @if (Auth::user() && Auth::user()->apartments()->exists())
        <a href="{{ route('admin.apartments.create') }}" class="btn btn-admin mb-3">Crea Nuovo Appartamento</a>
        <div id="map" style="width: 700px; height: 400px;"></div>
        <div class="table-responsive-md">
            <table id="res-table" class="table table-hover">
                <thead>
                    <tr class="r">
                        <th>Nome</th>
                        <th>Immagine</th>
                        <th class="visible">Visibile</th>
                        <th>Azione</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($apartments as $apartment)
                        <tr class="align-middle r">
                            <td data-title="name" class="w-25">{{ $apartment->name }}</td>
                            <td class="w-25" data-title="image">
                                <img src="{{ asset('storage/' . $apartment->cover_image) }}" alt="{{ $apartment->name }}">
                            </td>
                            <td data-title="visible" class="visible">{{ $apartment->visible ? 'Si' : 'No' }}</td>
                            <td data-title="actions">
                                <a href="{{ route('admin.apartments.show', $apartment->slug) }}" class="btn btn-admin"
                                    id="btnInfo"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.apartments.edit', $apartment->slug) }}" class="btn btn-admin"><i
                                        class="fas fa-pencil-alt"></i></a>
                                <form action="{{ route('admin.apartments.destroy', $apartment->slug) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-admin delete-button"><i
                                            class="fas fa-trash-alt"></i></button>
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
        <a href="{{ route('admin.apartments.create') }}" class="btn btn-admin my-3">Crea Nuovo Appartamento</a>
    @endif
@endsection

@section('scripts')
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.12.0/maps/maps-web.min.js"></script>
    <script>
        // Array di appartamenti con le loro coordinate
        var apartments = @json($apartments);

        // Inizializza la mappa TomTom con coordinate di default
        var map = tt.map({
            key: '88KjpqU7nmmEz3D6UYOg0ycCp6VqtdXI',
            container: 'map',
            center: [12.4964, 41.9028], // Centra la mappa su Roma
            zoom: 5 // Imposta un livello di zoom appropriato per vedere i marker
        });

        // Aggiungi marker per ciascun appartamento
        apartments.forEach(function(apartment) {
            // Verifica se le coordinate esistono e sono valide
            var latitude = parseFloat(apartment.latitude);
            var longitude = parseFloat(apartment.longitude);

            if (!isNaN(latitude) && !isNaN(longitude)) {
                var marker = new tt.Marker().setLngLat([longitude, latitude]).addTo(map);
                var popup = new tt.Popup({
                    offset: 35
                }).setText(apartment.name);
                marker.setPopup(popup);
            } else {
                console.error("Coordinate mancanti o non valide per l'appartamento: ", apartment);
            }
        });
    </script>
@endsection
