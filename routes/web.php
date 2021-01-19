<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/api/register', 'UserController@register');
Route::post('/api/login', 'UserController@login');
Route::get('/api/user', 'UserController@index');
Route::get('/api/user/{user_id}', 'UserController@show');
Route::get('/api/user/rol/{rol_id}', 'UserController@showUserByRol');
Route::put('/api/user/{user_id}', 'UserController@update');
Route::put('/api/user/password/{user_id}', 'UserController@updatePassword');
Route::delete('/api/user/{user_id}', 'UserController@destroy');

Route::resource('/api/rol', 'RolController');
Route::put('/api/rol/{rol_id}', 'RolController@update');

Route::post('/api/module', 'ModuleController@store');
Route::get('/api/module', 'ModuleController@index');
Route::get('/api/module/{module_id}', 'ModuleController@show');
Route::put('/api/module/{module_id}', 'ModuleController@update');
Route::delete('/api/module/{module_id}', 'ModuleController@destroy');

Route::post('/api/sector', 'SectorController@store');
Route::get('/api/sector', 'SectorController@index');
Route::get('/api/sector/{sector_id}', 'SectorController@show');
Route::put('/api/sector/{sector_id}', 'SectorController@update');
Route::delete('/api/sector/{sector_id}', 'SectorController@destroy');

Route::post('/api/service', 'ServiceController@store');
Route::get('/api/service', 'ServiceController@index');
Route::get('/api/service/{service_id}', 'ServiceController@show');
Route::put('/api/service/{service_id}', 'ServiceController@update');
Route::delete('/api/service/{service_id}', 'ServiceController@destroy');

Route::post('/api/card_type', 'CardTypeController@store');
Route::get('/api/card_type', 'CardTypeController@index');
Route::get('/api/card_type/{card_type_id}', 'CardTypeController@show');
Route::put('/api/card_type/{card_type_id}', 'CardTypeController@update');
Route::delete('/api/card_type/{card_type_id}', 'CardTypeController@destroy');

Route::post('/api/user_module', 'UserModuleController@store');
Route::get('/api/user_module', 'UserModuleController@index');
Route::get('/api/user_module/{user_module_id}', 'UserModuleController@show');
Route::put('/api/user_module/{user_module_id}', 'UserModuleController@update');
Route::delete('/api/user_module/{user_module_id}', 'UserModuleController@destroy');

Route::post('/api/question', 'QuestionController@store');
Route::get('/api/question', 'QuestionController@index');
Route::get('/api/question/status/{status}/rol/{rol_id}', 'QuestionController@questionFilter');
Route::get('/api/question/{question_id}', 'QuestionController@show');
Route::get('/api/question/user/{user_id}', 'QuestionController@showByUser');
Route::get('/api/question/status/{status}/rol/{rol_id}', 'QuestionController@questionFilter');
Route::put('/api/question/{question_id}', 'QuestionController@update');
Route::delete('/api/question/{question_id}', 'QuestionController@destroy');
Route::post('/api/question/email', 'QuestionController@sendEmail');

Route::post('/api/response', 'ResponseController@store');
Route::get('/api/response', 'ResponseController@index');
Route::get('/api/response/{response_id}', 'ResponseController@show');
Route::put('/api/response/{response_id}', 'ResponseController@update');
Route::delete('/api/response/{response_id}', 'ResponseController@destroy');
Route::get('/api/response/question/{question_id}', 'ResponseController@showByQuestion');

Route::post('/api/local', 'LocalController@store');
Route::get('/api/local', 'LocalController@index');
Route::get('/api/local/{local_id}', 'LocalController@show');
Route::get('/api/local/inquilino/{user_id}', 'LocalController@showLocalInquilino');
Route::get('/api/local/propietario/{user_id}', 'LocalController@showLocalPropietario');
Route::get('/api/local/sector/{sector_id}', 'LocalController@localFilter');
Route::put('/api/local/{local_id}', 'LocalController@update');
Route::delete('/api/local/{local_id}', 'LocalController@destroy');

Route::post('/api/local_service', 'LocalServiceController@store');
Route::get('/api/local_service', 'LocalServiceController@index');
Route::get('/api/local_service/local/{local_id}/service/{service_id}/year/{year}/status/{status}/month/{month}', 'LocalServiceController@localServicefilter');
Route::get('/api/local_service/{local_service_id}', 'LocalServiceController@show');
Route::get('/api/local_service/inquilino/{inquilino_id}', 'LocalServiceController@showInquilino');
Route::get('/api/local_service/propietario/{propietario_id}', 'LocalServiceController@showPropietario');
Route::get('/api/local_service/services_slopes/diagram', 'LocalServiceController@getServicesSlopes');
Route::get('/api/local_service/services_slopes/diagram/arrendamiento', 'LocalServiceController@getServicesSlopesArrendamiento');
Route::put('/api/local_service/{local_service_id}', 'LocalServiceController@update');
Route::put('/api/local_service/status/{local_service_id}', 'LocalServiceController@updateStatus');
Route::delete('/api/local_service/{local_service_id}', 'LocalServiceController@destroy');

Route::post('/api/payment_service', 'PaymentServiceController@store');
Route::get('/api/payment_service', 'PaymentServiceController@index');
Route::get('/api/payment_service/{payment_service_id}', 'PaymentServiceController@show');
Route::put('/api/payment_service/{payment_service_id}', 'PaymentServiceController@update');
Route::delete('/api/payment_service/{payment_service_id}', 'PaymentServiceController@destroy');

