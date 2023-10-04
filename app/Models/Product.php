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
      'name' , 'category_id' , 'image' ,'price' ,'compare_price' , 'description','status'
    ];

    protected static function booted()
    {
       static::addGlobalScope(new StoreScope('store'));
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
}
