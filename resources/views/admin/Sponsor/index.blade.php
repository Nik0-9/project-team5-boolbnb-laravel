@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Seleziona un appartamento da sponsorizzare</h1>
    
    <form action="{{ route('admin.sponsor.create')}}" method="GET">
        @csrf
        
        <div class="form-group">
            <label for="apartment_id">Seleziona un appartamento:</label>
            <select name="apartment_id" id="apartment_id" class="form-control mb-3 mt-3 w-50">
                @foreach($apartments as $apartment)
                    <option value="{{ $apartment->id }}">{{ $apartment->name }}</option>
                @endforeach
            </select>
        </div>
        <!-- <a href="{{route('admin.sponsor.store', $apartment->slug)}}" type="submit" class="btn btn-primary">avanti</a> -->
        <button type="submit" class="btn btn-primary">Avanti</button>
    </form>
</div>
<script>
    document.getElementById('apartment_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const slug = selectedOption.getAttribute('data-slug');
        const form = document.getElementById('apartmentForm');
        form.action = '/admin/' + slug + '/sponsor';
    });
</script>
@endsection
