<?php

use App\Models\Trove;
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
    
});