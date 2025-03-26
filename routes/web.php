<?php

use App\Models\Trove;
use App\Models\Collection;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group([
    'middleware' => 'set.locale',
], function () {

    Route::get('/', static function () {
        return redirect('/home');
    });

    Route::get('/home', function () {
        return view('components.home');
    })->name('home');

    Route::get('/resources/{slug}', function ($slug) {
        $resource = Trove::where('slug', $slug)->where('is_published', 1)->firstOrFail();
        return view('trove', compact('resource'));
    });

    Route::get('/collections/{id}', function ($id) {
        $collection = Collection::where('id', $id)->where('public', 1)->firstOrFail();
        return view('collection', compact('collection'));
    });
    
});