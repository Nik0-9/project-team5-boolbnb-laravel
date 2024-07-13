@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Messaggi dell'appartamento: {{ $apartment->name }}</h1>

    @if ($apartment->messages->isEmpty())
        <p>Non ci sono messaggi per questo appartamento.</p>
    @else
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
                @foreach ($apartment->messages as $message)
                <tr>
                    <td class="d-none d-md-table-cell">
                        {{ $message->apartment->name }}
                    </td>
                    <td>{{ $message->created_at->format('d/m/Y H:i:s') }}</td>
                        <td>{{ $message->created_at_formatted }}</td>
                        <td class="text-truncate d-none d-md-table-cell" style="max-width: 20px;">{{ $message->name }}
                            {{ $message->surname }}
                        </td>
                        <td class="text-truncate" style="max-width: 200pxpx;">{{ $message->email }}</td>
                        <td class="text-truncate" style="max-width: 100px;">{{ $message->body }}</td>
                        </a>
                        <td>
                            <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <a type="submit" class="color-admin p-2 delete-button">
                                    <i class="fas fa-trash-alt"></i></a>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($apartment->messages->isNotEmpty())
            @include('admin.partials.modal-delete-message')
        @endif
    @endif
</div>
@endsection
