@props([
        'type'=>'text' , 'name' , 'value'=>false ,'label'=>false
])
<x-form.label for="description">{{$label}}</x-form.label>

<input
    type="{{$type }}"
    name="{{$name}}"

    {{$attributes->class([
    'form-control',
    'is-invalid'=>$errors->has($name)
      ]) }}
    value="{{old($name , $value ) }}">
@error($name)
<div class="invalid-feedback">
    {{$message}}
</div>
@enderror
