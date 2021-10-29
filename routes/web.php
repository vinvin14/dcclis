<?php

use App\Models\Role;
use App\Repository\IARItemRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
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

// Route::get('role/{id}', function ($id, Request $request) {
//     $role = Http::get('http://192.168.224.68:50001/api/users/'.$id);
//     $permissions = [];
//     foreach ($role['roles'][0]['permissions'] as $row) {
//         array_push($permissions, $row['name']);
//     }
//     $response = new Response(view('dashboard'));
//     $response->withCookie(cookie()->forever('permissions', serialize($permissions)));
//     return $response;
// });

Route::get('roles/{id}', function ($id, Request $request) {
    $role = Role::query()
    ->with('permissions')
    ->find($id);

    $permissions = [];
    foreach ($role->permissions as $row) {
        $row = explode(':', $row->name);
        $permissions[$row[0]][] = $row[1];
    }

    $response = new Response(view('dashboard'));
    $response
    ->withCookie(cookie()->forever('role', $role->name))
    ->withCookie(cookie()->forever('permissions', serialize($permissions)));

    return $response;
});
Route::get('userid/{id}', function ($id) {
    $response = new Response('User id has been set!');
    return $response->withCookie(cookie()->forever('user_id', $id));
});
Route::middleware('verifyCredentials')->group(function() {
    Route::prefix('iar')->group(function () {
        Route::resource('logisticsOfficer', 'LogisticsOfficer\IARController')->names([
            'index' => 'iar.logisticsOfficer.list',
            'create' => 'iar.logisticsOfficer.create',
            'store' => 'iar.logisticsOfficer.store',
            'show' => 'iar.logisticsOfficer.show',
            'update' => 'iar.logisticsOfficer.update',
            'destroy' => 'iar.logisticsOfficer.destroy'
        ]);
    });
});
// Route::middleware('verifyCredentials')->group(function() {

//     Route::prefix('iar')->group(function () {
//         Route::resource('enduser', 'IarController');



//        Route::prefix('enduser')->group(function () {
//             Route::get('list', 'IarController@list')->name('iar.list');
//             Route::get('show/{iar}', 'IarController@show')->name('iar.show');
//             Route::get('create', 'IarController@create')->name('iar.create');
//             Route::get('edit/{iar}', 'IarController@edit')->name('iar.edit');

//             Route::put('update/{iar}', 'IarController@update')->name('iar.update');
//             Route::post('store', 'IarController@store')->name('iar.store');
//             Route::delete('destroy/{iar}', 'IarController@destroy')->name('iar.destroy');

//             Route::prefix('item')->group(function () {
//                 Route::get('show/{id}', 'IarItemController@show')->name('iar.item.show');
//                 Route::get('create/{iar}', 'IarItemController@create')->name('iar.item.create');
//                 Route::get('edit/{iarItem}', 'IarItemController@edit')->name('iar.item.edit');

//                 Route::put('update/{iarItem}', 'IarItemController@update')->name('iar.item.update');
//                 Route::post('store', 'IarItemController@store')->name('iar.item.store');
//                 Route::delete('destroy/{iarItem}', 'IarItemController@destroy')->name('iar.item.destroy');
//             });
//        });
//        Route::prefix('logisticsofficer')->group(function () {
//         Route::get('list', 'IarController@list')->name('iar.list');
//         Route::get('show/{iar}', 'IarController@show')->name('iar.show');
//         Route::get('create', 'IarController@create')->name('iar.create');
//         Route::get('edit/{iar}', 'IarController@edit')->name('iar.edit');

//         Route::put('update/{iar}', 'IarController@update')->name('iar.update');
//         Route::post('store', 'IarController@store')->name('iar.store');
//         Route::delete('destroy/{iar}', 'IarController@destroy')->name('iar.destroy');

//         Route::prefix('item')->group(function () {
//             Route::get('show/{id}', 'IarItemController@show')->name('iar.item.show');
//             Route::get('create/{iar}', 'IarItemController@create')->name('iar.item.create');
//             Route::get('edit/{iarItem}', 'IarItemController@edit')->name('iar.item.edit');

//             Route::put('update/{iarItem}', 'IarItemController@update')->name('iar.item.update');
//             Route::post('store', 'IarItemController@store')->name('iar.item.store');
//             Route::delete('destroy/{iarItem}', 'IarItemController@destroy')->name('iar.item.destroy');
//         });
//    });


    Route::prefix('ris')->group(function () {
        Route::resource('enduser', 'EndUser\RISController')->names([
            'index' => 'ris.enduser.list',
            'create' => 'ris.enduser.create',
            'store' => 'ris.enduser.store',
            'show' => 'ris.enduser.show',
            'update' => 'ris.enduser.update',
            'destroy' => 'ris.enduser.destroy'
        ]);


        // Route::get('list', 'RISController@list')->name('ris.list');
        // Route::get('show/{ris}', 'RISController@show')->name('ris.show');
        // Route::get('edit/{ris}', 'RISController@edit')->name('ris.edit');
        // Route::get('create', 'RISController@create')->name('ris.create');

        // Route::put('update/{ris}', 'RISController@update')->name('ris.update');
        // Route::get('destroy/{ris}', 'RISController@destroy')->name('ris.destroy');

        Route::prefix('item')->group(function () {
            Route::prefix('enduser')->group(function () {
                Route::get('show/{id}', 'EndUser\RisItemController@show')->name('ris.enduser.item.show');
                Route::post('store', 'EndUser\RisItemController@store')->name('ris.enduser.item.store');
                Route::get('destroy/{id}', 'EndUser\RisItemController@destroy')->name('ris.item.destroy');
            });
        });
    });




    // Route::view('test/ris/create', 'test.ris.create');
    // Route::get('test/ris/create-cookie', 'RISController@create_cookie');

    // Route::view('/', 'account.login')->name('account.login');
    Route::view('dashboard', 'dashboard')->name('dashboard');


    Route::get('getrole/logistics', function () {
        return redirect(route('dashboard'))
        ->withCookie(cookie()->forever('role', 'Logistics Officer'));
    });
    Route::get('clearCookie', function (Request $request) {
        Cookie::queue(Cookie::forget('office'));
        Cookie::queue(Cookie::forget('role'));
    });

    Route::prefix('ajax')->group(function () {
        Route::get('ris/{id}', 'AjaxController@getRis');
        Route::get('iar/items/forris/{office}/{category}', 'AjaxController@getItemsForRis');

        Route::get('iar/item/{office}/{id}', 'AjaxController@getIarItem');
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
    // Route::get('roles/show', function (Request $request) {
    //     dd($request->cookie('roles'));
    // });
    Route::get('permissions/show', function (Request $request) {
        $cookie = unserialize($request->cookie('permissions'));
        if (in_array('iar:view', $cookie)) {

        }

        dd($cookie);
    });

    Route::get('getItems', function () {
        return (new IARItemRepository)->getIarItemsByOffice(1, 1);
    });

    Route::get('getitems/{office}/{id}', function ($office, $id) {

        return (new IARItemRepository())->getIarItem($office, $id);
    });

    // Route::prefix('purchaseOrder')->group(function () {
    //     Route::get('list', 'PurchaseOrderController')->name('purchaseOrder.list');
    //     Route::get('show/{id}', 'PurchaseOrderController@show')->name('purchaseOrder.show');
    // });

// });

