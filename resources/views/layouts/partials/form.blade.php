<div class="form-group">
    <label for="name">Nome</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', isset($apartment) ? $apartment->name : '') }}" required>
</div>
<div class="form-group">
    <label for="cover_image">Immagine di Copertina</label>
    <input type="text" class="form-control" id="cover_image" name="cover_image" value="{{ old('cover_image', isset($apartment) ? $apartment->cover_image : '') }}" required>
</div>
<div class="form-group">
    <label for="address">Indirizzo</label>
    <input type="text" class="form-control" id="address" name="address" value="{{ old('address', isset($apartment) ? $apartment->address : '') }}" required>
</div>
<div class="form-group">
    <label for="description">Descrizione</label>
    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', isset($apartment) ? $apartment->description : '') }}</textarea>
</div>
<div class="form-group">
    <label for="square_meters">Metri Quadrati</label>
    <input type="number" class="form-control" id="square_meters" name="square_meters" value="{{ old('square_meters', isset($apartment) ? $apartment->square_meters : '') }}" required>
</div>
<div class="form-group">
    <label for="num_bathrooms">Numero di Bagni</label>
    <input type="number" class="form-control" id="num_bathrooms" name="num_bathrooms" value="{{ old('num_bathrooms', isset($apartment) ? $apartment->num_bathrooms : '') }}" required>
</div>
<div class="form-group">
    <label for="num_beds">Numero di Letti</label>
    <input type="number" class="form-control" id="num_beds" name="num_beds" value="{{ old('num_beds', isset($apartment) ? $apartment->num_beds : '') }}" required>
</div>
<div class="form-group">
    <label for="num_rooms">Numero di Stanze</label>
    <input type="number" class="form-control" id="num_rooms" name="num_rooms" value="{{ old('num_rooms', isset($apartment) ? $apartment->num_rooms : '') }}" required>
</div>
<div class="form-group">
    <label for="visible">Visibile</label>
    <input type="checkbox" id="visible" name="visible" value="1" {{ old('visible', isset($apartment) ? $apartment->visible : 1) ? 'checked' : '' }}>
</div>