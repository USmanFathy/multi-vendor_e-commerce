<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Str;

class BasePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

//    public function before($user , $ability)
//    {
//        if($user->super_admin){
//            return true;
//        }
//    }

    public function __call($name , $arguments)
    {
        $class_name =str_replace('Policy' ,'' ,class_basename($this));
        $base_name = Str::plural(Str::lower($class_name)); // like roles.view
        $ability = $base_name.'.'.$name;
        $user = $arguments[0];

        return $user->hasAbility($ability);
    }
}
