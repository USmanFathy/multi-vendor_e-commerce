<?php

namespace App\Http\Controllers\front;

use App\Events\OrderCreated;
use App\Exceptions\CartEmptyException;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;
use Throwable;

class CheckOutController extends Controller
{
    public function create(CartRepository $cart)
    {
        if ($cart->get()->count()==0){
            throw new CartEmptyException('Cart is Empty');
        }
        $countries = Countries::getNames('EN');

        return view('front.checkout' , compact('cart' ,'countries'));
    }

    public function store(Request $request ,CartRepository $cart)
    {
        $request->validate([
            'address.billing.first_name' => ['required'],
            'address.billing.last_name' => ['required'],
            'address.billing.email' => ['required'],
            'address.billing.phone_number' => ['required'],
            'address.billing.city' => ['required'],
//            'address.billing.*' => ['string'],


        ]);
        $order_store = $cart->get()->groupBy('product.store_id')->all();
//        dd($order_store);
        DB::beginTransaction();
        try {

            foreach ($order_store as $store_id => $product){
                $order = Order::create([
                    'store_id' => $store_id ,
                    'user_id' => auth()->id(),
                    'payment_method' =>'cod',
                ]);



            foreach ($product as $item){
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);
            }

            foreach ($request->post('address')as $type =>$address)
            {
                $address['type'] = $type;
                $order->addresses()->create($address);
            }
            }

            DB::commit();
            event(new  OrderCreated($order));
        }catch (Throwable $e){
            DB::rollBack();
            throw $e;
        }

        return redirect()->route('home');
    }
}
