@extends('layouts.app')

@section('content')
<!-- Begin Page Content -->
<div class=" d-flex justify-content-between align-items-center">
    <h1 class="my-4 ms-5">Messaggi</h1>

    <select name="apartment" id="message_apartment" class="form-control my-4 me-5 w-25">
        @foreach ($apartments as $apartment)
            <option value="{{ $apartment->id }}">{{ $apartment->name }}</option>
        @endforeach
    </select>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive-md">
                        @if ($messages->isEmpty())
                            <p>Non ho trovato nulla.</p>
                        @else
                            <div class="list-group">
                                @foreach ($messages as $message)
                                    <div class="list-group-item list-group-item-action" data-apartment-id="{{ $message->apartment->id }}">
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
<style scope>
    .list-group-item-action a {
        text-decoration: none;
        color: inherit;
        cursor: pointer;

    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectElement = document.getElementById('message_apartment');
    const messages = document.querySelectorAll('.list-group-item[data-apartment-id]');

    selectElement.addEventListener('change', function () {
        const selectedApartmentId = selectElement.value;

        messages.forEach(message => {
            if (selectedApartmentId === "" || message.getAttribute('data-apartment-id') === selectedApartmentId) {
                message.style.display = 'block';
            } else {
                message.style.display = 'none';
            }
        });
    });
});
</script>