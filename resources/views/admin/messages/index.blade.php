@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <h1 class="mb-4">Messaggi</h1>

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
                                    <div class="list-group-item list-group-item-action">
                                <a href=" {{ route('admin.messages.show', $message->id) }}">

                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{ $message->apartment->name }}</h5>
                                            <small>{{ $message->created_at }}</small>
                                        </div>
                                        <p>{{ $message->body }}</p>
                                        <p class="mb-1"><small><strong>Nome utente: </strong>{{ $message->name }} {{$message->surname}}</small></p>
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

    @include('admin.partials.modal-delete-message')
@endsection
<style scope>
.list-group-item-action a {
        text-decoration: none; 
        color: inherit;
        cursor: pointer; 
      
    }
</style>