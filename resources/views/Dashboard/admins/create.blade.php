@extends('layouts.dashboard')
@section('title_section' ,'Product')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Add Product</li>
@endsection
@section('content')

    <form action="{{route('products.store')}}" method="post" enctype="multipart/form-data" >
    @csrf
        @include('dashboard.products.form', [
    'button_label' => 'Create'
])
</form>
@endsection
