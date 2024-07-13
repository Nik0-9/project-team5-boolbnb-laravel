@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="my-4">
            <h1 class="h3 mb-0 text-gray-800 fs-1">Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-12 col-xl-6">
                @auth
                    <h2>{{ __('Benvenuto, :name!', ['name' => Auth::user()->name]) }}</h2>
                @endauth
                <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Totale Messaggi Ricevuti</h5>
                        <p class="card-text">{{ $totalMessages }}</p>
                    </div>
                </div>
            </div>
                <h3>Ultimi messaggi</h3>
                @foreach ($apartments as $apartment)
                    <div class="card mb-2">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column">
                                <h5 class="card-title">{{ $apartment->name }}</h5>
                                <p class="card-text">Nuovi Messaggi:{{ $apartment->messages_count }}</p>
                            </div>
                            <div>
                                <img src="{{ asset('storage/' . $apartment->cover_image)}}" alt="{{ $apartment->name }}"
                                    style="width: 200px; height: 150px">
                            </div>
                        </div>
                        <div class="d-flex p-2 gap-2">
                            <a href="{{ route('admin.apartments.messages', $apartment->slug) }}"
                                class="btn btn-admin w-50">Visualizza Messaggi</a>
                            <a href="{{ route('admin.apartments.show', $apartment->slug) }}"
                                class="btn btn-admin w-50 ">Vedi Appartamento</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
</div>
@endsection