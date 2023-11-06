<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ProductsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('delete','store' ,'update');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products =Product::filter($request->query())
            ->with('category:id,name','store:id,name','tags:id,name')
            ->paginate();
        return  ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      =>'required|string|min:3|max:255',

            'image'    =>[
                'image','max:1048576','dimensions:min_width=150 , min_height=100'
            ],
            'status' => 'in:active,archived,draft',
            'compare_price' =>'nullable , gt:price'
        ]);
        $user = $request->user();
        if(!$user->tokenCan('products.create')){
            return response([
                'message'=>'Not Allowed',

            ],403);
        }
        $product = Product::create($request->all()) ;
        return Response::json($product ,201 );
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'      =>'sometimes|required|string|min:3|max:255',

            'image'    =>[
                'image','max:1048576','dimensions:min_width=150 , min_height=100'
            ],
            'status' => 'in:active,archived,draft',
            'compare_price' =>'nullable , gt:price'
        ]);
        $product->update($request->all()) ;
        return Response::json($product  );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::destroy($id);
        return \response()->json([
            'message' => 'product deleted'
        ],200);
    }
}
