<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\DashboardConroller;
use Illuminate\Support\Facades\Route;


Route::group([
    'middleware'=> ['auth'],
    'prefix'    => 'dashboard'
] , function (){
    Route::get('/' , [DashboardConroller::class , 'index'])->name('dashboard');
    Route::resource('/categories' , CategoriesController::class);

});
