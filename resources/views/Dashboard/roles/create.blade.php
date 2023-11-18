@extends('layouts.dashboard')
@section('title_section' ,'Add Category')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Add Role</li>
@endsection
@section('content')

    <form action="{{route('roles.store')}}" method="post" enctype="multipart/form-data" >
    @csrf
        @include('dashboard.roles.form', [
    'button_label' => 'Create'
])
</form>
@endsection
