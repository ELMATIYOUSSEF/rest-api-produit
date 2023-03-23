<?php

use Illuminate\Http\Request;
use App\Enums\PermissionType;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CategorieController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::controller(AuthController::class)->group(function () {

    Route::post('login', 'login');
    Route::post('register', 'register');

    Route::middleware('auth:api')->group(function(){

        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
        Route::post('/search/{Idcategories}', [FilterController::class,'searchByCategory']);
        Route::get('/filter/{Namecategories}', [FilterController::class,'filterByName']);
    
    Route::middleware(['role'=>'admin'])->group(function(){
        Route::put('/changeRole/{user}', [UserController::class,'changeRole']);
        Route::apiResource('/role', RoleController::class);
    });

     // Route::apiResource('/produits', ProduitController::class);
    // Route::apiResource('/categories', CategorieController::class);
    // Route::apiResource('/users', UserController::class);

    Route::group(['controller' => UserController::class,'prefix' => 'users'], function () {
        Route::get('', 'index')->middleware([PermissionType::VIEWProfil]);
        Route::get('/{user}', 'show')->middleware([PermissionType::VIEWProfil]);
        Route::put('/{user}', 'update')->middleware([PermissionType::EDITALLProfil,PermissionType::EDITMYProfil]);
        Route::delete('/{user}', 'destroy')->middleware([PermissionType::DELETEALLProfil,PermissionType::DELETEMYProfil]);
        Route::put('/pass/{user}', 'update_password')->middleware([PermissionType::EDITALLProfil,PermissionType::EDITMYProfil]);
    });

    Route::group(['controller' => CategorieController::class, 'prefix'=>'categories' ], function () {
        Route::get('', 'index')->middleware([PermissionType::VIEWCATEGORY]);
        Route::post('', 'store')->middleware([PermissionType::CREATECATEGORY]);
        Route::get('/{category}', 'show')->middleware([PermissionType::VIEWCATEGORY]);
        Route::put('/{category}', 'update')->middleware([PermissionType::EDITCATEGORY]);
        Route::delete('/{category}', 'destroy')->middleware([PermissionType::DELETECATEGORY]);
    });
    
    Route::group(['controller' => ProduitController::class, 'prefix' => 'produits'], function () {
        Route::get('', 'index')->middleware([PermissionType::VIEWPRODUIT]);
        Route::post('', 'store')->middleware([PermissionType::CREATEPRODUIT]);
        Route::get('/{produit}', 'show')->middleware([PermissionType::VIEWPRODUIT]);
        Route::put('/{produit}', 'update')->middleware([PermissionType::EDITALLPRODUIT,PermissionType::EDITMYPRODUIT]);
        Route::delete('/{produit}', 'destroy')->middleware([PermissionType::DELETEALLPRODUIT,PermissionType::DELETEMYPRODUIT]);
    });
});
});