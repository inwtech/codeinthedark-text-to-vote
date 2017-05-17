<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    //
    public static function save_vote($phone_number, $voted_for)
    {
        $phone_number = preg_replace('/\D/', '', $phone_number);
        $active_round = \App\Round::where('is_current', 1)->first();

        $has_voted = Vote::where('phone_number', $phone_number)->where('round_id', $active_round->id)->first();
        if (null != $has_voted) {
            return 'Sorry, you can only vote once.';
        }

        $vote = new Vote();
        $vote->phone_number = $phone_number;
        $vote->vote_casted = $voted_for;
        $vote->round_id = $active_round->id;
        $vote->save();

        return 'Thank you, your vote has been recorded';
    }
}
