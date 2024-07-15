@extends('layouts.app')

@section('content')
<div class="">
    <div class="my-4">
        <h1 class="h3 mb-0 text-gray-800 fs-1">Dashboard</h1>
    </div>
    <div class="row">
        <div class="col-12 col-lg-6">
            <div>
                @auth
                    <h2>{{ __('Benvenuto, :name!', ['name' => Auth::user()->name]) }}</h2>
                @endauth
            </div>
        </div>
        <div class="col-12 col-lg-6">

        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-6 mb-3">
                    <h5 class="d-inline">Totale Messaggi Ricevuti</h5>
                    <strong class="d-inline">{{ $totalMessages }}</strong>
            @foreach ($apartments as $apartment)
                <div class="card my-2">
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
                        <a href="{{ route('admin.apartments.show', $apartment->slug) }}" class="btn btn-admin w-50 ">Vedi
                            Appartamento</a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-12 col-lg-6">
            <h3 class="mb-4">I tuoi Appartamenti Sponsorizzati</h3>

            @foreach ($sponsored as $apartment)
                <div class="card mb-2">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="d-flex flex-column">
                            <h5 class="card-title">{{ $apartment->name }}</h5>
                            @foreach ($apartment->sponsors as $sponsor)
                                Sponsor: <p class="card-text">{{ $sponsor->name }}</p>
                            @endforeach
                        </div>
                        <div>
                            <img src="{{ asset('storage/' . $apartment->cover_image)}}" alt="{{ $apartment->name }}"
                                style="width: 200px; height: 150px">
                        </div>
                    </div>
                    <div class="d-flex p-2 gap-2">

                        <a href="{{ route('admin.apartments.show', $apartment->slug) }}" class="btn btn-admin w-50 ">Vedi
                            Appartamento</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection