<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AuthController;

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

/*
 *  User Credentials
 */
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::group(['middleware'=>['auth:sanctum']],function(){
    /*
     * Employee Api Route List
    */
    Route::get('get-employee-list',[EmployeeController::class,'get_employee_list']);
    Route::get('get-single-employee-info/{emp_id}',[EmployeeController::class,'get_single_employee_info']);
    Route::post('create-employee',[EmployeeController::class,'create_employee']);
    Route::put('update-employee/{emp_id}',[EmployeeController::class,'update_employee']);
    Route::delete('delete-employee/{emp_id}',[EmployeeController::class,'delete_employee']);

    /*
     * Post Api Route List
    */
    Route::get('get-post-list',[PostController::class,'get_post_list']);
    Route::get('get-single-post-info/{post_id}',[PostController::class,'get_single_post_info']);
    Route::post('create-post',[PostController::class,'create_post']);

    /*
     * Category Api Route List
    */
    Route::get('get-category-list',[CategoryController::class,'get_category_list']);
    Route::get('get-single-category-info/{cat_id}',[CategoryController::class,'get_single_category_info']);
    Route::post('create-category',[CategoryController::class,'create_category']);
    Route::put('update-category/{cat_id}',[CategoryController::class,'update_category']);
    Route::delete('delete-category/{cat_id}',[CategoryController::class,'delete_category']);

    /*
     * Tag Api Route List
    */
    Route::get('get-tag-list',[TagController::class,'get_tag_list']);
    Route::get('get-single-tag-info/{tag_id}',[TagController::class,'get_single_tag_info']);
    Route::post('create-tag',[TagController::class,'create_tag']);
    Route::put('update-tag/{tag_id}',[TagController::class,'update_tag']);
    Route::delete('delete-tag/{tag_id}',[TagController::class,'delete_tag']);

    /*
     * Logout
    */
    Route::post('/logout',[AuthController::class,'logout']);
});


