
<option value=""></option>
@foreach ($locations as $location)
    <option value="{{ $location->id_location }}" @if(isset($previous_id_location) && $previous_id_location == $location->id_location) selected @endif>{{ $location->name }}</option>
@endforeach
