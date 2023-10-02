@props([
        'type'=>'radio' , 'name' , 'options', 'checked' ,'label'=>false
])
<x-form.label for="description">{{$label}}</x-form.label>

@foreach($options as $value =>$text)
    <div class="form-check">

        <input type="{{$type}}" name="{{$name}}"  value="{{$value}}" @checked(old($name,$checked)   == $value )
            {{$attributes->class([
    'form-check-inpu'
])}}
        >
        <label for="" class="form-check-label">{{$text}}</label>
    </div>
@endforeach

{{--<div class="form-check">--}}
{{--    <input type="{{$type}}" name="{{$name}}" class="form-check-input" value="{{$value2}}" @checked(old($name ,$value_static)   == $value2 )>--}}
{{--    <label for="" class="form-check-label">{{$value2}}</label>--}}
{{--</div>--}}


