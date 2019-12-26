<option value="allsubdepts">Select All</option>
@if(!empty($subdepartments))
    @foreach($subdepartments as $key => $value)
        <option value="{{ $key }}">{{ $value }}</option>
    @endforeach
@endif
