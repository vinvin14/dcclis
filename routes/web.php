<?php

use App\Repository\IARItemRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
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


// Route::middleware('verifyCredentials')->group(function() {

    Route::prefix('iar')->group(function () {
        Route::get('list', 'IarController@list')->name('iar.list');
        Route::get('show/{iar}', 'IarController@show')->name('iar.show');
        Route::get('create', 'IarController@create')->name('iar.create');
        Route::get('edit/{iar}', 'IarController@edit')->name('iar.edit');
        
        Route::put('update/{iar}', 'IarController@update')->name('iar.update');
        Route::post('store', 'IarController@store')->name('iar.store');
        Route::delete('destroy/{iar}', 'IarController@destroy')->name('iar.destroy');

        Route::prefix('item')->group(function () {
            Route::get('show/{id}', 'IarItemController@show')->name('iar.item.show');
            Route::get('create/{iar}', 'IarItemController@create')->name('iar.item.create');
            Route::get('edit/{iarItem}', 'IarItemController@edit')->name('iar.item.edit');

            Route::put('update/{iarItem}', 'IarItemController@update')->name('iar.item.update');
            Route::post('store', 'IarItemController@store')->name('iar.item.store');
            Route::delete('destroy/{iarItem}', 'IarItemController@destroy')->name('iar.item.destroy');
        });
    });

    Route::prefix('ris')->group(function () {
        Route::get('list', 'RISController@list')->name('ris.list');
        Route::get('show/{ris}', 'RISController@show')->name('ris.show');
        Route::get('edit/{ris}', 'RISController@edit')->name('ris.edit');
        Route::get('create', 'RISController@create')->name('ris.create');

        Route::put('update/{ris}', 'RISController@update')->name('ris.update');
        Route::get('destroy/{ris}', 'RISController@destroy')->name('ris.destroy');
    });


    Route::view('test/ris/create', 'test.ris.create');
    Route::get('test/ris/create-cookie', 'RISController@create_cookie');

    Route::view('/', 'account.login')->name('account.login');
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('getrole', function () {
        return redirect(route('dashboard'))
        ->withCookie(cookie()->forever('role', 'End User'));
    });


    Route::prefix('ajax')->group(function () {
        Route::get('ris/{id}', 'AjaxController@getRis');
        Route::get('ris/items/{office}/{category}', 'AjaxController@getItemsForRis');
    });
   

    Route::get('{role}/permissions', function ($role) {
        $permissions = [
            'ris:approve',
            'ris:create',
            'ris:store',
            'ris:update',
            'ris:delete'
        ];

        return redirect(route('dashboard'))
        ->withCookie(cookie()->forever('permissions', serialize($permissions)));
    });
    Route::get('roles/show', function (Request $request) {
        dd($request->cookie('roles'));
    });
    Route::get('permissions/show', function (Request $request) {
        $cookie = unserialize($request->cookie('permissions'));
        dd($cookie);
    });

    Route::get('getItems', function () {
        return (new IARItemRepository)->getItemsByOffice(1, 1);
    });

    // Route::prefix('purchaseOrder')->group(function () {
    //     Route::get('list', 'PurchaseOrderController')->name('purchaseOrder.list');
    //     Route::get('show/{id}', 'PurchaseOrderController@show')->name('purchaseOrder.show');
    // });

// });

