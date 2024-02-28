
<option value=""></option>
@foreach ($directories as $directory)
    <option value="{{ $directory->id_directory }}" @if(isset($previous_id_directory) && $previous_id_directory == $directory->id_directory) selected @endif>{{ $directory->name }}</option>
@endforeach
