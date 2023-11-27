@extends('layouts.dashboard')
@section('title_section' ,'Edit Role')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"> Roles</li>
    <li class="breadcrumb-item active">Edit Role</li>
@endsection
@section('content')

    <form action="{{route('roles.update' , $role->id)}}" method="post" enctype="multipart/form-data">
    @csrf
     @method('put')
    @include('dashboard.roles.form' , [
    'button_label' => 'Update'
])
</form>


@endsection
