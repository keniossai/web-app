
<option value=""></option>
@foreach ($guides as $guide)
    <option value="{{ $guide->id_guide }}" @if(isset($previous_id_guide) && $previous_id_guide == $guide->id_guide) selected @endif>{{ $guide->name }}</option>
@endforeach
