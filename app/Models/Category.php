<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class  Category extends Model
{
    use HasFactory , SoftDeletes;


    protected $fillable = [ //white list
      'name',
      'parent_id',
      'description',
      'status',
      'image',
      'slug'
    ];


//    public function ScopeActive(Builder $builder){
//        $builder->where('status','=','active');
//    }
//
//    public function ScopeStatus(Builder $builder , $status){
//        $builder->where('status','=',$status);
//    }

    public function ScopeSearch(Builder $builder ,$filters){
            $builder->when($filters['name'] ?? false , function ($builder , $value){
                $builder->where('categories.name','LIKE' , "%{$value}%");
            });
        $builder->when($filters['status'] ?? false , function ($builder , $value){
            $builder->where('categories.status',$value);
        });
//        if($filters['name'] ?? false){ //asigned and comparing
//
//        }
//        if($filters['status'] ?? false){ //asigned and comparing
//        }
    }

    public function ScopeParentName($builder)
    {
        $builder->leftJoin('categories as parents' , 'parents.id' , '=' ,'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name'
            ]);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class , 'parent_id', 'id')->withDefault([
            'name' => 'Main Category'
        ]);
    }
    public function childern()
    {
        return $this->hasMany(Category::class, 'category_id' ,'id');
    }

}
