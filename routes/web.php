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
    return view('module');
})->name('landing-page');

Route::fallback(function () {
    return view('module');
});

Route::get('close_popup', function () {
    return view('close_popup');
})->name('close_popup');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    // Route::get('/categories','CategoryController@category');
    // Route::get('/tags','TagController@tag');
    Route::group(['namespace' => 'Auth', 'middleware' => 'guest'], function () {
        Route::get('login', 'LoginController@index')->name('admin.index');
        Route::post('login', 'LoginController@login')->name('admin.login');
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::get('dashboard', 'DashboardController@dashboard')->name('admin.dashboard');

        Route::get('user', 'UserController@index')->name('admin.user');
        Route::get('user/create', 'UserController@create')->name('admin.user.create');
        Route::get('user/{user}', 'UserController@edit')->name('admin.user.edit');
        Route::post('user/update/{id}', 'UserController@update')->name('admin.user.update');
        Route::post('user/store', 'UserController@store')->name('admin.user.store');
        Route::delete('user/delete', 'UserController@remove')->name('admin.user.delete');
        Route::delete('user/deletebulk', 'UserController@bulkRemove')->name('admin.user.bulkdelete');
        Route::post('user/upload', 'UserController@upload');

        Route::post('logout', 'AdminController@logout')->name('admin.logout');
    });
});
