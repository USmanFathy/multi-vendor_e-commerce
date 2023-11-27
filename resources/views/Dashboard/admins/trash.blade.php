@extends('layouts.dashboard')
@section('title_section' ,'Trashed Product')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Product</li>
    <li class="breadcrumb-item active">Trash</li>
@endsection
@section('content')


    <div class="mb-5">
        <a href="{{route('products.index')}}" class="btn btn-sm btn-outline-primary">Back</a>
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
            <option value="draft" @selected(request('status')== 'draft')>Draft</option>

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

        @forelse($products as $product)
            <tr>
                <td><img height="50" src="{{asset('storage/'.$product->image)}}"></td>
                <td>{{$product->id}}</td>
                <td>{{$product->name}}</td>
                <td>{{$product->parent_name}}</td>
                <td>{{$product->status}}</td>
                <td>{{$product->deleted_at}}</td>
                <td>
                    <form action="{{route('categories.restore' , $product->id)}}" method="post">
                        @csrf
                        {{--  form method spoofing--}}
                        @method('put')
                        <button class="btn btn-sm btn-outline-info">Restore</button>


                    </form>                </td>
                <td>
                    <form action="{{route('categories.force-delete' , $product->id)}}" method="post">
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
