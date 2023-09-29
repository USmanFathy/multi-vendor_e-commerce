@extends('layouts.dashboard')
@section('title_section' ,'Trashed Categories')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
    <li class="breadcrumb-item active">Trash</li>
@endsection
@section('content')


    <div class="mb-5">
        <a href="{{route('categories.index')}}" class="btn btn-sm btn-outline-primary">Back</a>
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
            <th>Image</th>
            <th>Id</th>
            <th>Name</th>
            <th>Parent</th>
            <th>Status</th>
            <th>Delete At</th>
            <th colspan="2"></th>

        </tr>
        </thead>
        <tbody>

        @forelse($categories as $category)
            <tr>
                <td><img height="50" src="{{asset('storage/'.$category->image)}}"></td>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td>{{$category->parent_name}}</td>
                <td>{{$category->status}}</td>
                <td>{{$category->deleted_at}}</td>
                <td>
                    <form action="{{route('categories.restore' , $category->id)}}" method="post">
                        @csrf
                        {{--  form method spoofing--}}
                        @method('put')
                        <button class="btn btn-sm btn-outline-info">Restore</button>


                    </form>                </td>
                <td>
                    <form action="{{route('categories.force-delete' , $category->id)}}" method="post">
                        @csrf
                      {{--  form method spoofing--}}
                        @method('delete')
                        <button class="btn btn-sm btn-outline-danger">Delete</button>


                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" >No Categories Defined .</td>
            </tr>
        @endforelse


        </tbody>
    </table>

    {{$categories->withQueryString()->links()}}

    <!-- /.row -->

@endsection
