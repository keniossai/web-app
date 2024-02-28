
<option value=""></option>
@foreach ($centralpractices as $centralpractice)
    <option value="{{ $centralpractice->id_central_practice }}" @if(isset($previous_id_central_practice) && $previous_id_central_practice == $centralpractice->id_central_practice) selected @endif>{{ $centralpractice->name }}</option>
@endforeach
