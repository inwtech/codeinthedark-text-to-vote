<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Round extends Model
{
    //
    public function vote_count()
    {
        $count = DB::table('votes')
            ->select(DB::raw('count(*) as vote_count'))
            ->where('round_id', $this->getKey())
            ->first()
        ;

        return $count->vote_count;
    }

    public static function active_vote_breakdown($seat_number_index = false)
    {
        $active_round = \App\Round::where('is_current', 1)->first();

        if (empty($active_round)) {
            return [];
        }

        $votes = DB::table('votes')
            ->select(DB::raw('count(*) as vote_count, vote_casted'))
            ->where('round_id', $active_round->getKey())
            ->groupBy('vote_casted')
            ->orderBy('vote_casted')
            ->get()
        ;

        $data = [];
        foreach ($votes as $vote) {
            $data[$vote->vote_casted] = $vote->vote_count;
        }

        $votes = [];
        for ($i = 1; $i < $active_round->seats; $i++) {
            $votes[($seat_number_index) ? 'seat-'.$i : $i-1] = isset($data[$i]) ? $data[$i] : 0;
        }

        return $votes;
    }
}
