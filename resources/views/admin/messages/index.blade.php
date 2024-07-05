@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
   <h1 class="mb-4">Messaggi</h1>
    <!-- <a href="{{ route('admin.messages.index') }}" class="btn btn-primary mb-3">Torna agli appartamenti</a> -->
    <div class="table-responsive-md">
    <table id="res-table" class="table table-hover">
        <thead>
            <tr class="text-center">
                <th>Nome Appartamento</th>
                <th>Email</th>
                <th>Messaggio</th>
                <th>Ricevuto il</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($apartments as $apartment )
            @foreach ($messages as $message)
                <tr class="align-middle text-center">
                    
                    <td data-title="name" class="w-25">{{ $apartment->name }}</td>
                    <td class="w-25" data-title="image">{{$message->email}}</td>
                    <td data-title="address" class="w-25">{{ $message->body }}</td>
                    <td data-title="visible" class="visible">{{$message->created_at}}</td>
                </tr>
                @endforeach
            @endforeach
           
        </tbody>
    </table>
    </div>

    @include('admin.partials.modal-delete')
@endsection
