@extends('layouts.app')

@section('content')

<div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center">
    <h1 class="my-4 pe-2">Messaggi</h1>

    <div class="d-flex flex-column flex-md-row my-4 me-5 w-100 w-lg-auto align-items-center">
        <select name="apartment" id="message_apartment" class="form-control me-2 mb-2 mb-md-0 w-25 w-md-auto">
            <option value="">Seleziona appartamento</option>
            @foreach ($apartments as $apartment)
                <option value="{{ $apartment->id }}">{{ $apartment->name }}</option>
            @endforeach
        </select>

        <button id="filter_button" class="btn btn-admin w-25 w-md-auto me-2">Filtra per data</button>
        Da: <input type="date" id="start_date" class="form-control mb-2 mb-md-0 w-25 w-md-auto me-2">
        A: <input type="date" id="end_date" class="form-control mb-2 mb-md-0 w-25 w-md-auto">
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="list-group">
                        @if ($messages->isEmpty())
                            <p>La ricerca non ha trovato risultati.</p>
                        @else
                            @foreach ($messages as $message)
                                <div class="list-group-item list-group-item-action"
                                    data-apartment-id="{{ $message->apartment->id }}" data-date="{{ $message->created_at }}">
                                    <a href=" {{ route('admin.messages.show', $message->id) }}">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{ $message->apartment->name }}</h5>
                                            <small>{{ $message->created_at }}</small>
                                        </div>
                                        <p>{{ $message->body }}</p>
                                        <p class="mb-1"><small><strong>Nome utente: </strong>{{ $message->name }}
                                                {{$message->surname}}</small></p>
                                        <div class="d-flex w-100 justify-content-between">
                                            <small><strong>Email: </strong> {{ $message->email }}</small>
                                            <!-- Form di eliminazione -->
                                            <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger p-1 delete-button">
                                                    Cancella messaggio
                                                </button>
                                            </form>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if ($messages->isEmpty())
@else()
    @include('admin.partials.modal-delete-message')
@endif

@endsection

<style>
    .list-group-item-action a {
        text-decoration: none;
        color: inherit;
        cursor: pointer;
    }

    @media (max-width: 992px) {
        .d-flex.flex-column.flex-lg-row {
            flex-direction: column ;
            width: 600px;
            
        }

        .d-flex.flex-column.flex-md-row {
            flex-direction: column ;
        }
    }
</style>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectElement = document.getElementById('message_apartment');
        const messages = document.querySelectorAll('.list-group-item[data-apartment-id]');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const filterButton = document.getElementById('filter_button');

        const filterMessages = () => {
            const selectedApartmentId = selectElement.value;
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            endDate.setDate(endDate.getDate() + 1); // Include end date in the range

            messages.forEach(message => {
                const messageDate = new Date(message.getAttribute('data-date'));
                const matchesApartment = selectedApartmentId === "" || message.getAttribute('data-apartment-id') === selectedApartmentId;
                const matchesDate = (!isNaN(startDate) && !isNaN(endDate)) ? (messageDate >= startDate && messageDate < endDate) : true;

                if (matchesApartment && matchesDate) {
                    message.style.display = 'block';
                } else {
                    message.style.display = 'none';
                }
            });
        };

        selectElement.addEventListener('change', filterMessages);
        filterButton.addEventListener('click', filterMessages);

        startDateInput.addEventListener('change', function () {
            endDateInput.min = startDateInput.value;
        });

        endDateInput.addEventListener('change', function () {
            startDateInput.max = endDateInput.value;
        });
    });
</script>
@endsection