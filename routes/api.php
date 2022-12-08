<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PostController;
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
    Route::get('single-post-info/{post_id}',[PostController::class,'get_single_post_info']);

    /*
     * Category Api Route List
    */


    /*
     * Tag Api Route List
    */

    Route::post('/logout',[AuthController::class,'logout']);
});


