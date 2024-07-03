
@extends('layouts.app')

@section('content')
<form action="{{ route('admin.sponsors.store') }}" method="POST">
@csrf
<div>
   <h1 class="mb-5 fs-2">Sponsorizza struttura</h1>
  
    <h5 class="mb-4 fw-medium fs-5">Quale struttura vuoi promuovere?</h5> 
    <div class="mb-4">
        <select name="apartment_id" id="apartment-select" class="form-select">
            @foreach ($apartments as $apartment)
                <option value="{{ $apartment->id }}">{{ $apartment->name }} - {{ $apartment->address }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="mt-5">
    <h5 class="mb-4 fw-medium fs-5">Seleziona piano</h5> 
    <div class="card">
        <div class="card-body">
                <div class="mb-3">
                    <label for="sponsor_id" class="form-label">sponsor</label>
                    <select name="sponsor_id" id="sponsor_id" class="form-select">
                        @foreach($sponsors as $sponsor)
                            <option value="{{ $sponsor->id }}">{{ $sponsor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div value="{{ $sponsor->id }}">{{ $sponsor->price}}</div>
                
                <div class="mb-3">
                    <label for="screening_date" class="form-label">Screening Date</label>
                    <input type="date" name="screening_date" id="screening_date" class="form-control" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Aggiungi piano</button>
        </div>
    </div>
</div>
</form>
<script>

</script>
@endsection