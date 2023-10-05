<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CartController extends Controller
{
    protected $cart;
    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        $repository = App::make('cart');

        return view('front.cart' , ['cart' => $this->cart]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request )
    {
        $request->validate([
            'product_id' =>['required' , 'int' ,'exists:products,id'],
            'quantity'   => ['nullable' , 'int' ,'min:1'],
        ]);
        $product = Product::findOrFail($request->post('product_id'));
//        $repository = App::make('cart');
        $this->cart->add($product , $request->post('quantity'));


//        if ($request->exceptsJson()){
//                return  response()->json([
//                    'message' =>'product added to cart'
//                ]);
//        }
        return redirect()->route('cart.index')->with('success' , 'Added To Cart');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request ,$id)
    {
        $request->validate([
//            'product_id' =>['required' , 'int' ,'exists:products,id'],
            'quantity'   => ['required' , 'int' ,'min:1'],
        ]);
//        $product = Product::findOrFail($request->post('product_id'));
//        $repository = App::make('cart');
//        dd($id);
        $this->cart->update($id , $request->post('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->cart->delete($id);
    }
}
