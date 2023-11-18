@extends('layouts.dashboard')
@section('title_section' ,"$category->name")
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
    <li class="breadcrumb-item active">{{$category->name}}</li>

@endsection
@section('content')

    <table class="table table-striped table-info table-hover">
        <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Store</th>
            <th>Status</th>
            <th>Created At</th>

        </tr>
        </thead>
        <tbody>
        @php

        $products = $category->products()->with('store')->paginate(5);

        @endphp

        @forelse(  $products as $product)
            <tr>
                <td><img height="50" src="{{asset('storage/'.$product->image)}}"></td>
                <td>{{$product->name}}</td>
                <td>{{$product->store->name }}</td>
                <td>{{$product->status}}</td>
                <td>{{$product->created_at}}</td>

            </tr>
        @empty
            <tr>
                <td colspan="6" >No Products Defined .</td>
            </tr>

        @endforelse


        </tbody>

    </table>

    {{$products->withQueryString()->links()}}



@endsection
