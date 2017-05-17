<?php

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

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

/**
 * Settings:
 * current_round:
 *
 * Rounds:
 * number
 * seats
 *
 * Votes:
 * phone_number
 * casted_vote
 * round_number
 */
Route::get('/superspecialadminsection', function(Request $request) {



    return view('admin');
});

Route::post('/superspecialadminsection', function(Request $request) {



    return redirect('/superspecialadminsection');
});