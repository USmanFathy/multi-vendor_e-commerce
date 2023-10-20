<?php

namespace App\Actions\Fortify;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class CustomLogin
{
public function login($request){

    $user_name = $request->post(config('fortify.username'));
    $password = $request->post('password');

    $user = Admin::whereEmail($user_name)
                    ->orwhere('username',$user_name)
                    ->orwhere('phone_number',$user_name)->first();

    if ($user && Hash::check($password , $user->password)) {
        return $user;
    }
    return false;
}
}
