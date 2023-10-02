<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;

class ProfileController extends Controller
{
    public function edit()
    {
        $countries = Countries::getNames('EN');
        $locals = Languages::getNames('EN');
        $user = auth()->user();
        return view('Dashboard.profile.edit',compact('user','countries' ,'locals'));
    }

    public function update (Request $request)
    {
        $request->validate([
            'first_name' => ['required' , 'string' , 'max:255','min:4'],
            'last_name' => ['required' , 'string' , 'max:255','min:4'],
            'birthday' => ['nullable' , 'date' , 'before:today'],
            'gender'   =>['in:male,female'],
            'country'  =>['required' , 'string' ,'size:2']
        ]);
        $user = $request->user();
        $profile =$user->profile;
        $profile->fill($request->all())->save();
//        if($profile->first_name){
//            $profile->update($request->all());
//        }else{
////            $request->merge([
////                'user_id' => $user->id,
////            ]);
////            Profile::create($request->all());
//            $user->profile()->create($request->all());
//        }
        return redirect()->route('dashboard.profile.edit')->with('success' , 'Profile Updated!');
    }
}
