<div class="form-group">
    <!-- NOME -->
    <label for="name">Nome</label>
    <input type="text" class="form-control" id="name" name="name"
        value="{{ old('name', isset($apartment) ? $apartment->name : '') }}" required maxlength="200">
</div>
@error('name')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<!-- IMMAGINE -->
<div class="form-group">
    <label for="cover_image">Immagine di Copertina</label>
    <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*" required>
</div>

<!-- @error('cover_image')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror -->

<!-- INDIRIZZO -->
<label for="address">Indirizzo</label>
<div class="d-flex border rounded p-2">
    <div class="me-3 w-25">
        <label for="street">Via</label>
        <input type="text" class="form-control w-100" name="street" id="street" required minlength="8" maxlength="150">
    </div>
    @error ('street')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <div class="me-3 w-25">
        <label for="street_number">Numero Civico</label>
        <input type="text" class="form-control" name="street_number" id="street_number" required minlength="1">
    </div>
    @error ('street_number')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <div class="me-3 w-25">
        <label for="city">Città</label>
        <input type="text" class="form-control" name="city" id="city" required maxlength="150">
    </div>
    @error ('city')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <div class="me-3 w-25">
        <label for="cap">Cap</label>
        <input type="text" class="form-control @error('cap') is-invalid @enderror" name="cap" id="cap" required
            pattern="^\d{5}$" minlength="5" maxlength="5">
    </div>
    @error ('cap')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
<!-- DESCRIZIONE -->
<div class="form-group">
    <label for="description">Descrizione</label>
    <textarea class="form-control" id="description" name="description" rows="3" minlength="20">
        {{ old('description', isset($apartment) ? $apartment->description : '') }} 
    </textarea>
</div>
@error('description')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<!-- METRI QUADRI -->
<div class="form-group">
    <label for="square_meters">Metri Quadrati</label>
    <input type="number" class="form-control" id="square_meters" name="square_meters"
        value="{{ old('square_meters', isset($apartment) ? $apartment->square_meters : '') }}" required minlength="20">
</div>
@error('square_meters')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<!-- NUMERO BAGNI -->
<div class="form-group">
    <label for="num_bathrooms">Numero di Bagni</label>
    <input type="number" class="form-control" id="num_bathrooms" name="num_bathrooms"
        value="{{ old('num_bathrooms', isset($apartment) ? $apartment->num_bathrooms : '') }}" required minlength="1">
</div>
@error('num_bathrooms')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<!-- NUMERO LETTI -->
<div class="form-group">
    <label for="num_beds">Numero di Letti</label>
    <input type="number" class="form-control" id="num_beds" name="num_beds"
        value="{{ old('num_beds', isset($apartment) ? $apartment->num_beds : '') }}" required minlength="1">
</div>
@error('num_beds')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<!-- NUMERO STANZE -->
<div class="form-group">
    <label for="num_rooms">Numero di Stanze</label>
    <input type="number" class="form-control" id="num_rooms" name="num_rooms"
        value="{{ old('num_rooms', isset($apartment) ? $apartment->num_rooms : '') }}" required minlength="1">
</div>
@error('num_rooms')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<div class="d-none">
    <input type="number" id="user" name="user_id" value="{{old('user_id', $apartment->user_id ?? '')}}">
</div>