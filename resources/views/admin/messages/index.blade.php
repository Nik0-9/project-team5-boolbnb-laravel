@extends('layouts.app')

@section('content')

<h1 class="my-4 pe-2">Messaggi</h1>

<div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center">
    <div class="my-4 me-5 w-100 w-lg-auto">
        <form action="{{ route('admin.messages.index') }}" method="GET" class="d-flex align-items-center">
            <select name="apartment" id="message_apartment" class="form-control me-2 mb-2 mb-md-0 flex-grow-1" style="max-width: 200px;">
                <option value="">Seleziona appartamento</option>
                @foreach ($apartments as $apartment)
                    <option value="{{ $apartment->id }}" {{ $selected_apartment_id == $apartment->id ? 'selected' : '' }}>
                        {{ $apartment->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" id="filter_button" class="btn btn-admin ms-2">Filtra</button>
        </form>
    </div>
</div>

<div class="container-fluid table-responsive">
<table class="table table-hover">
    <thead>
        <tr>
            <th class="d-none d-md-table-cell">Nome Appartamento</th>
            <th>Data</th>
            <th class="d-none d-md-table-cell">Nome Utente</th>
            <th>Email</th>
            <th>Messaggio</th>
            <th>Azioni</th>
        </tr>
    </thead>
    <tbody>
        @if ($messages->isEmpty())
            <tr>
                <td colspan="6">La ricerca non ha trovato risultati.</td>
            </tr>
        @else
            @foreach ($messages as $message)
                <tr data-href="{{ route('admin.messages.show', $message->id) }}">
                    <td class="d-none d-md-table-cell">
                            {{ $message->apartment->name }}
                    </td>
                    <td>{{ $message->created_at_formatted }}</td>
                    <td  class="text-truncate d-none d-md-table-cell" style="max-width: 20px;">{{ $message->name }} {{ $message->surname }}</td>
                    <td class="text-truncate" style="max-width: 200pxpx;">{{ $message->email }}</td>
                    <td class="text-truncate" style="max-width: 100px;">{{ $message->body }}</td>
                    </a>
                    <td>
                        <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <a type="submit" class="color-admin p-2 delete-button">
                                <i class="fas fa-trash-alt"></i></a>
                        </form>
                    </td>   
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
</div>
@if ($messages->isNotEmpty())
    @include('admin.partials.modal-delete-message')
@endif

@endsection
@section('styles')
<style>
    a {
        text-decoration: none;
        color: inherit;
        cursor: pointer;
    }

    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    tr[data-href] {
        cursor: pointer;
    }

    @media (max-width: 992px) {
        .d-flex.flex-column.flex-lg-row {
            flex-direction: column;
            width: 600px;
        }

        .d-flex.flex-column.flex-md-row {
            flex-direction: column;
        }

        .d-lg-table-cell {
            display: none !important;
        }
    }

    @media (max-width: 767.98px) {
        .d-md-table-cell {
            display: none !important;
        }
    }
</style>
@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rows = document.querySelectorAll('tr[data-href]');

        rows.forEach(row => {
            row.addEventListener('click', function (e) {
                if (e.target.closest('td').querySelector('form') === null) {
                    window.location = this.dataset.href;
                }
            });
        });
    });
</script>
@endsection