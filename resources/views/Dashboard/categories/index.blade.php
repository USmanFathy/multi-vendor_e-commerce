@extends('layouts.dashboard')
@section('title_section' ,'Categories')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection
@section('content')


    <div class="mb-5">
        <a href="{{route('categories.create')}}" class="btn btn-sm btn-outline-primary">Create</a>
    </div>
    @if(session()->has('add'))
        <div class="alert alert-success">
            {{session('add')}}
        </div>
    @endif
    @if(session()->has('edit'))
        <div class="alert alert-info">
            {{session('edit')}}
        </div>
    @endif
    @if(session()->has('delete'))
        <div class="alert alert-danger">
            {{session('delete')}}
        </div>
    @endif
    <table class="table table-striped table-info table-hover">
        <thead>
        <tr>
            <th></th>
            <th>Id</th>
            <th>name</th>
            <th>parent</th>
            <th>created_at</th>
            <th colspan="2"></th>

        </tr>
        </thead>
        <tbody>

        @forelse($categories as $category)
            <tr>
                <td><img height="50" src="{{asset('storage/'.$category->image)}}"></td>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td>{{$category->parent_id}}</td>
                <td>{{$category->created_at}}</td>
                <td>
                    <a href="{{route('categories.edit' , $category->id)}}" class="btn btn-sm btn-outline-success">Edit</a>
                </td>
                <td>
                    <form action="{{route('categories.destroy' , $category->id)}}" method="post">
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

    <!-- /.row -->

@endsection
