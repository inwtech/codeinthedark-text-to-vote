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

use App\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    $data = json_encode(Round::active_vote_breakdown());

    return view('welcome', compact('data'));
});

Route::post('/save-vote', function() {
    header('Content-type: text/xml');
    echo '<Response>';

    $phone_number = $_REQUEST['From'];
    $team_number = (int) $_REQUEST['Body'];

    if ((strlen($phone_number) >= 10) && ($team_number > 0) ) {
        $response = \App\Vote::save_vote($phone_number, $team_number);
    } else {
        $response = 'Sorry, I didn\'t understand that. Text the seat number to vote. For example, texting 1 will cast a vote for Seat 1.';
    }

    echo '<Sms>'.$response.'</Sms>';
    echo '</Response>';
    die;
});

Route::get('/get-votes', function() {
    $data = Round::active_vote_breakdown();

    return $data;
});

Route::get('/superspecialadminsection', function(Request $request) {
    return view('admin');
});

Route::post('/superspecialadminsection', function(Request $request) {

    if ($request->get('seats')) {
        $round = new \App\Round();
        $round->seats = $request->get('seats');
        $round->is_current = 0;
        $round->save();
    }

    if ($request->get('active_round')) {
        DB::table('rounds')
            ->update(['is_current' => 0])
        ;

        DB::table('rounds')
            ->where('id', $request->get('active_round'))
            ->update(['is_current' => 1])
        ;
    }

    return redirect('/superspecialadminsection');
});