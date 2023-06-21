<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Project;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::get('/allproject', 'ProjectController@allproject');
Route::get('/categories/{id}', 'ProjectController@categories_show');
Route::get('/show_creativeproject/{slug}', 'ProjectController@show_creativeproject');
Route::post('/add_commentsproject', 'CommentsProjectController@store');
Route::post('/complaint_project', 'ComplaintProjectController@store');
Route::post('/complaint_comment', 'ComplaintCommentController@store');
Route::get('/show_project_members/{id}', 'PhotoMemberController@show');


Route::group(['middleware' => ['role_creator']], function () {
    Route::get('/project', 'ProjectController@index');
    Route::post('/project', 'ProjectController@ProjectForm')->name('validate.form');
    Route::get('/project_edit/{id}', 'ProjectController@showProject');
    Route::post('/project_edit/{id}', 'ProjectController@update');

    Route::get('/project_delete/{id}', 'ProjectController@destroy')->name('project_delete.destroy');

    Route::get('/history_donated', 'DonationController@history_donated');

    Route::get('/project_members', 'PhotoMemberController@index');
    
    Route::post('/project_members', 'PhotoMemberController@AddMemberForm');
    Route::get('/delete_members/{id}', 'PhotoMemberController@delete'); 


    Route::get('/exclusive_list', 'ExclusiveMaterialController@index'); 
    Route::post('/exclusive_list', 'ExclusiveMaterialController@add'); 
    Route::get('/exclusive_delete/{id}', 'ExclusiveMaterialController@destroy'); 
    Route::get('/exclusive_edit/{id}', 'ExclusiveMaterialController@exclusive_edit'); 

     Route::post('/exclusive_edit/{id}', 'ExclusiveMaterialController@update');
     

});
Route::group(['middleware' => ['role_user']], function () {
    

    Route::get('/my_donates', 'DonationController@show_donated');

    Route::post('/add_donation', 'DonationController@add_donation');


    Route::get('/add_donation',['as' => 'status', 'uses' => 'DonationController@getPaymentStatus']);
       Route::get('/show_exclusivematerials/{slug}', 'ExclusiveMaterialController@show');

});
Route::group(['middleware' => ['role_manager']], function () {
    Route::get('/project_manager', 'ManagerController@project_manager');
    Route::get('/projectmanager_edit/{id}', 'ManagerController@showProject');
    Route::post('/projectmanager_edit/{id}', 'ManagerController@update_project');
    Route::get('/projectmanager_delete/{id}', 'ManagerController@destroy_project');

    Route::get('/categoriesmanager_show', 'ManagerController@categoriesmanager_show');
    Route::post('/categoriesmanager_create', 'ManagerController@categoriesmanager_create');
    Route::get('/categoriesmanager_edit/{id}', 'ManagerController@categoriesmanager_edit');
    Route::post('/categoriesmanager_edit/{id}', 'ManagerController@categoriesmanager_update');
    Route::get('/categoriesmanager_delete/{id}', 'ManagerController@destroy_categories');
    Route::get('/complaintmanager_show', 'ManagerController@complaintmanager_show'); 


    Route::post('/complaint_done', 'ComplaintProjectController@complaint_done');


    Route::get('/commentsmanager_show', 'ManagerController@commentsmanager_show'); 
    Route::get('/delete_comment/{id}', 'CommentsProjectController@delete'); 


   


     Route::get('/complaint_comments', 'ManagerController@complaintcommentsmanager_show'); 

     Route::post('/complaintcomments_done', 'ComplaintCommentController@complaint_done');

});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');
Route::get('logout', function (){
    auth()->logout();
    Session()->flush();

    return Redirect::to('/');
})->name('logout');

Auth::routes();
