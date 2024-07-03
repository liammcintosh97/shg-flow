@props(['disabled' => false, 'options'])

@if ($options)
  <select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>
    @foreach (json_decode($options) as $option )
      <option value={{$option->value}}>{{$option->label}}</option>
    @endforeach
  </select>
@endif
