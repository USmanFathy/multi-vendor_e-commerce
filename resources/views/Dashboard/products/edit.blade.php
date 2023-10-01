@extends('layouts.dashboard')
@section('title_section' ,'Edit Category')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit Category</li>
@endsection
@section('content')

    <form action="{{route('categories.update' , $category->id)}}" method="post" enctype="multipart/form-data">
    @csrf
     @method('put')
    @include('dashboard.categories.form' , [
    'button_label' => 'Update'
])
</form>


@endsection
