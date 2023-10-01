@extends('layouts.dashboard')
@section('title_section' ,'Add Category')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Add Category</li>
@endsection
@section('content')

    <form action="{{route('categories.store')}}" method="post" enctype="multipart/form-data" >
    @csrf
        @include('dashboard.categories.form', [
    'button_label' => 'Create'
])
</form>
@endsection
