<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\DashboardConroller;
use Illuminate\Support\Facades\Route;


Route::group([
    'middleware'=> ['auth'],
    'prefix'    => 'dashboard'
] , function (){
    Route::get('/' , [DashboardConroller::class , 'index'])->name('dashboard');
    /////////////////////////////////////Categories////////////////////////////////////
    Route::get('/categories/trash' , [CategoriesController::class , 'trash'])->name('categories.trash');
    Route::put('/categories/{category}/restore' , [CategoriesController::class , 'restore'])->name('categories.restore');
    Route::delete('/categories/{category}/force-delete' , [CategoriesController::class , 'force_delete'])->name('categories.force-delete');
    Route::resource('/categories' , CategoriesController::class);
    ///////////////////////////////////////////////////////////////////////////////////





});
