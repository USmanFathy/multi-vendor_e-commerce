<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [ //white list
      'name',
      'parent_id',
      'description',
      'status',
      'image',
      'slug'
    ];

    public static function rules(){
        return [
            'name'      =>'required|string|min:3|max:255',
            'parent_id' =>[
                'int' , 'exists:categories,id' ,'nullable'
            ],
            'image'    =>[
                'image','max:1048576','dimensions:width=150 , height=100'
            ],
            'status' => 'in:active,archived'
        ];
}

}
