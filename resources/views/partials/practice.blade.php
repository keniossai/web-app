
<option value=""></option>
@foreach ($practices as $practice)
    <option value="{{ $practice->id_practice }}" @if(isset($previous_id_practice) && $previous_id_practice == $practice->id_practice) selected @endif>{{ $practice->name }}</option>
@endforeach
