<?php

use App\Http\Services\AccountServices;
use App\Models\Iar;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\Office;
use App\Models\Role;
use App\Models\User;
use App\Repository\IARItemRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
Route::get('user', function () {
    dd(Auth::user());
});

Route::get('userid/{id}', function ($id) {

    $user = User::query()
    ->with('roles.permissions')
    ->find($id);

    Auth::login($user);

    $response = new Response('User id has been set!');
    return $response->withCookie(cookie()->forever('user_id', $id));
});



Route::middleware([
    'verifyCredentials',
    'auth'
])->group(function() {
    Route::get('dashboard', 'MainController@dashboard')->name('dashboard');
    Route::group([
        // 'middleware' => 'iar',
        'prefix' => 'logisticsofficer',
        'as' => 'logisticsofficer.'
    ], function () {
        Route::resource('iar', 'LogisticsOfficer\IARController');
        Route::group([
            'prefix' => 'iar',
            'as' => 'iar'
        ], function () {
                Route::resource('item', 'LogisticsOfficer\IARItemController');
        });

        Route::get('ris', 'LogisticsOfficer\RISController@index')->name('logisticsofficer.ris.list');
        Route::get('ris/{id}', 'LogisticsOfficer\RISController@show')->name('logisticsofficer.ris.show');
        Route::get('ris/edit/{id}', 'LogisticsOfficer\RISController@edit')->name('logisticsofficer.ris.edit');
        Route::put('ris/update/{id}', 'LogisticsOfficer\RISController@update')->name('logisticsofficer.ris.update');
    });

    Route::group([
        'prefix' => 'enduser',
        'as' => 'enduser.'
    ], function () {
        //create middleware
        // Route::resource('ris','EndUser\RISController');

        // Route::resource('logisticsofficer', 'LogisticsOfficer\RISController');

        Route::group([
            'prefix' => 'item',
            'as' => 'item.'
        ], function () {
            Route::resource('enduser', 'EndUser\RisItemController');


            // Route::resource('logisticsofficer', 'LogisticsOfficer\RISItemController');
        });
    });

});

Route::prefix('account')->group(function () {
    Route::get('role/verify', 'AccountController@AccountVerify')->name('account.role.verify');
    Route::get('role/confirm', 'AccountController@confirmRole')->name('account.role.confirm');
    Route::get('role/show', function (Request $request) {
        dd($request->cookie('role'));
    });
});


    Route::get('items', function () {
        // dd(ItemCategory::
        // with('item')
        // ->get());
        $items = Item::
        with('itemCategory')
        ->get();
        // dd($items);

        foreach ($items as $item) {

           echo @$item->itemCategory->name.'<br>';
        }
    });

    Route::get('iar/{id}', function ($id) {
        return Iar::with('iarItem')->where('id', $id)->get();
    });
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('sbadminb5', function () {
        return view('layout.sbadminb5.index');
    });

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

    Route::prefix('axios')->group(function () {
        Route::get('items', 'AxiosController@itemsByCategory');
        Route::get('offices', 'AxiosController@offices');

        //iar item
        Route::get('iar/item', 'AxiosController@getIarItem');
        Route::put('iar/item/{id}', 'AxiosController@udpateIarItem');
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

