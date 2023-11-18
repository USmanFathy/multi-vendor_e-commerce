@extends('layouts.dashboard')
@section('title_section' ,'Roles')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Roles</li>
@endsection
@section('content')


    <div class="mb-5">
        <a href="{{route('roles.create')}}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
        <a href="{{route('roles.trash')}}" class="btn btn-sm btn-outline-dark">Trash</a>
    </div>
    <x-alert type="success"/>
    <x-alert type="info"/>
    <x-alert type="danger"/>

    <form action="{{URL::current()}}" method="get" class="d-flex justify-content-between mb-4">
        <x-form.input name="name" placeholder="Search By Name" class="mx-2" :value="request('name')"/>
        <select name="status" class="form-control mx-2">
            <option value="">All</option>
            <option value="active" @selected(request('status')== 'active')>Active</option>
            <option value="archived" @selected(request('status')== 'archived')>Archived</option>
        </select>
        <button class="btn btn-dark mx-2">Filter</button>
    </form>
    <table class="table table-striped table-info table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>


        </tr>
        </thead>
        <tbody>

        @forelse($roles as $role)
            <tr>
                <td>{{$role->id}}</td>
                <td><a href="{{route('roles.show' , $role->id)}}">{{$role->name}}</a></td>

                <td>
                    <a href="{{route('roles.edit' , $role->id)}}" class="btn btn-sm btn-outline-success">Edit</a>
                </td>
                <td>
                    <form action="{{route('roles.destroy' , $role->id)}}" method="post">
                        @csrf
                      {{--  form method spoofing--}}
                        @method('delete')
                        <button class="btn btn-sm btn-outline-danger">Delete</button>


                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" >No roles Defined .</td>
            </tr>
        @endforelse


        </tbody>
    </table>

    {{$roles->withQueryString()->links()}}

    <!-- /.row -->

@endsection
