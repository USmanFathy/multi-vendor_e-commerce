<?php

namespace App\Models;

use App\Observers\CartObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory;

    public $incrementing = false ;
    protected $fillable =
        [
            'cookie_id' , 'user_id' ,'product_id' ,'quantity' ,'options'
        ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Anonymous'
        ]);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    //events (observers)
    // creating , created , updating , updated , saving ,saved
    // deleting , deleted , restoring , restored , retrieved

    protected static function booted()
    {
        static::observe(CartObserver::class);
        static::addGlobalScope('cookie_id' ,function (Builder $builder){
            $builder->where('cookie_id' , Cart::getCookieId());
        });
    }

    public static function getCookieId()
    {
        $cookie_id = Cookie::get('cart_id');
        if (!$cookie_id)
        {
            $cookie_id = Str::uuid();
            $current = Carbon::now();

            $trialExpires = $current->addDays(30);
            $numberOfDays = $current->diffInDays($trialExpires);
            Cookie::queue('cart_id' , $cookie_id ,$numberOfDaysphp);
        }

        return $cookie_id;
    }
}
