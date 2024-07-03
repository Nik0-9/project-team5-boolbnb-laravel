@extends('layouts.app')

@section('content')
    <h1>Apartment Sponsors</h1>

    <div class="mb-3">
        <a href="{{ route('admin.apartment_sponsors.create') }}" class="btn btn-primary">Create New Association</a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Apartment</th>
                <th>Sponsor</th>
                <th>Price</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($apartments as $apartmentSponsor)
                @foreach($apartmentSponsor->sponsors as $sponsor)
                    <tr>
                        <td>{{ $apartmentSponsor->name }}</td>
                        <td>{{ $sponsor->name }}</td>
                        <td>{{ $sponsor->pivot->price }}</td>
                        <td>{{ $sponsor->pivot->start_date }}</td>
                        <td>{{ $sponsor->pivot->end_date }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
@endsection
