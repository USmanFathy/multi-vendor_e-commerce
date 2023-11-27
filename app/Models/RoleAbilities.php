<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleAbilities extends Model
{
    use HasFactory;

    protected $fillable =[
        'role_id',
        'ability',
        'type'
    ];
    public $timestamps =false;
}
