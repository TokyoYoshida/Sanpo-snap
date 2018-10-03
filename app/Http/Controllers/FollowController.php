<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\Follow;
use Illuminate\Support\Facades\Log;

class FollowController extends Controller
{
    public function follows($id) {
        $target_user = User::find($id);
        if ($target_user === null) {
            abort(404);
        }

        $auth_user = User::find(auth()->id());

        $follows = DB::table('follows as a')
                        ->select('u.*', 'b.followee_id as is_following')
                        ->join('users as u', 'a.followee_id', '=', 'u.id')
                        ->leftJoin('follows as b', function ($join) use ($auth_user) {
                            if($auth_user !== null) {
                                $join->on('a.followee_id', '=', 'b.followee_id')
                                    ->on('b.follower_id', '=', DB::raw($auth_user->id));
                            } else {
                                $join->on('a.followee_id', '=', 'b.followee_id')
                                    ->on('b.follower_id', '=', DB::raw(-1)); // dummy value. it never match the condition
                            }
                        })
                        ->where('a.follower_id', '=', $target_user->id)
                        ->get();
        return view('follows_show', [
            'follows' => $follows,
            'auth_user' => $auth_user,
            'target_user' => $target_user,
        ]);
    }

    public function follower($id) {
        $target_user = User::find($id);
        if ($target_user === null) {
            abort(404);
        }

        $auth_user = User::find(auth()->id());

        $follows = DB::table('follows as a')
            ->select('u.*', 'b.followee_id as is_following')
            ->join('users as u', 'a.follower_id', '=', 'u.id')
            ->leftJoin('follows as b', function ($join) use ($auth_user) {
                if($auth_user !== null) {
                    $join->on('a.follower_id', '=', 'b.followee_id')
                        ->on('b.follower_id', '=', DB::raw($auth_user->id));
                } else {
                    $join->on('a.follower_id', '=', 'b.followee_id')
                        ->on('b.follower_id', '=', DB::raw(-1)); // dummy value. it never match the condition
                }
            })
            ->where('a.followee_id', '=', $target_user->id)
            ->get();
        return view('follower_show', [
            'follows' => $follows,
            'auth_user' => $auth_user,
            'target_user' => $target_user,
        ]);
    }
}
