@extends('layouts.dashboard')
@section('title_section' ,'Edit Product')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit Product</li>
@endsection
@section('content')

    <form action="{{route('products.update' , $product->id)}}" method="post" enctype="multipart/form-data">
    @csrf
     @method('put')
    @include('dashboard.products.form' , [
    'button_label' => 'Update'
])
</form>


@endsection
