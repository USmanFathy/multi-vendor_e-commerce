<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable =[
      'name' , 'category_id' , 'image' , 'store_id','price' ,'compare_price' , 'description','status'
    ];

    protected $hidden =
        [
            'created_at' ,'updated_at' , 'deleted_at','image'
        ];
    protected $appends =[
        'image_url'
    ];
    protected static function booted()
    {
       static::addGlobalScope(new StoreScope('store'));
       static::creating(function (Product $product){
           $product->slug = Str::slug($product->name);
       });

        static::updating(function (Product $product){
            $product->slug = Str::slug($product->name);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class , 'category_id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class , 'store_id');
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class , // related model
            'product_tag' , // pivot table name
            'product_id', // fk in pivot table current model
            'tag_id' , // fk in pivot table for related model
            'id' ,        // pk current model
            'id');          // pk related model
    }
    public function ScopeSearch(Builder $builder ,$filters){
        $builder->when($filters['name'] ?? false , function ($builder , $value){
            $builder->where('products.name','LIKE' , "%{$value}%");
        });
        $builder->when($filters['status'] ?? false , function ($builder , $value){
            $builder->where('products.status',$value);
        });}

    public function ScopeActive(Builder $builder)
    {
        $builder->where('status' , '=','active');
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image){
            return 'https://dharmapurionline.com/wp-content/uploads/2017/03/default-product-image.jpg';
        }
        if (Str::startsWith($this->image ,['http://','https://']))
        {
            return $this->image;
        }

        return asset('storage/'.$this->image);


    }

    public function getDiscountRateAttribute()
    {
        if (!$this->compare_price)
        {
          return 0;
        }
        return round(100 - ($this->price/ $this->compare_price *100 ) ,1 );
    }

    public function scopeFilter(Builder $builder , $filters)
    {
        $options = array_merge([
            'store_id' => null,
            'category_id'=>null,
            'tag_id'=>[],
            'status'=>'active'
        ],$filters);
        $builder->when($options['status'] , function ($builder ,$value){
            $builder->where('status' , $value);
        });
        $builder->when($options['store_id'] , function ($builder ,$value){
            $builder->where('store_id' , $value);
        });
        $builder->when($options['category_id'] , function ($builder ,$value){
            $builder->where('category_id' , $value);
        });
        $builder->when($options['tag_id'] , function ($builder ,$value){

//            $builder->whereRaw('EXISTS (SELECT 1 FROM product_tag WHERE tag_id = ? AND product_id = products.id)' , [$value]);

            $builder->whereExits(function($query)use($value){
                $query->select(1)
                    ->from('product_tag')
                    ->whereRaw('product_id = products.id')
                    ->where('tag_id' , $value);
            });

        });
    }
}
