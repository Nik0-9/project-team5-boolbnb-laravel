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
                            <div class="list-group">
                                @foreach ($messages as $message)
                                    <div class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{ $message->apartment->name }}</h5>
                                            <small>{{ $message->created_at }}</small>
                                        </div>
                                        <p class="mb-1">{{ $message->body }}</p>

                                        <div class="d-flex w-100 justify-content-between">
                                        <small>Email: {{ $message->email }}</small>
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
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.modal-delete')
@endsection
