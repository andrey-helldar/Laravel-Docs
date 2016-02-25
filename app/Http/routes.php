<?php
/*
  |--------------------------------------------------------------------------
  | Routes File
  |--------------------------------------------------------------------------
  |
  | Here is where you will register all of the routes in an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('/', function () {
    return redirect()->route('docs', ['version' => config('settings.version', '5.2')]);
});

Route::get('/docs', function () {
    return redirect()->route('docs', ['version' => config('settings.version', '5.2')]);
});

//  https://laravel.com/docs/5.2
Route::get('docs/{version}/{page?}', ['as' => 'docs', 'uses' => 'DocsController@page']);



/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | This route group applies the "web" middleware group to every route
  | it contains. The "web" middleware group is defined in your HTTP
  | kernel and includes session state, CSRF protection, and more.
  |
 */

Route::group(['middleware' => ['web']], function () {
    //
});
