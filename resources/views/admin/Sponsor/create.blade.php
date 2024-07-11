@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sponsorizza <span>{{$apartment->name}}</span></h1>
    
    <form action="{{ route('admin.payment.page') }}" method="GET">
        @csrf
        
        <div class="form-group">
            <label for="sponsor_id">Scegli un pacchetto di sponsorizzazione:</label>
            <select name="sponsor_id" id="sponsor_id" class="form-control mb-3 mt-3 w-25">
                @foreach($sponsors as $sponsor)
                    <option value="{{ $sponsor->id }}">{{ $sponsor->name }} - €{{ $sponsor->price }} per {{ $sponsor->duration }} ore</option>
                @endforeach
            </select>
        </div>

        <input type="hidden" name="apartment_id" value="{{ $apartment->id }}">

        <button type="submit" class="btn btn-primary">Sponsorizza</button>
    </form>
</div>
@endsection