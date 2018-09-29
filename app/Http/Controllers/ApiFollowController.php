<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Follow;

class ApiFollowController extends Controller
{
    /**
     * add follow
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function follow_add($id, Request $request)
    {
        $user = User::find(auth()->id());

        $follow = new Follow();
        $follow->followee_id = $id;
        $follow->follower_id = $user->id;
        $follow->save();

        $count = Follow::where('followee_id', $id)->count();

        return response([$count]);
    }

    /**
     * del follow
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function follow_del($id, Request $request)
    {
        $follower = User::find(auth()->id());
        $follower->follows()->where('followee_id', '=', $id)->delete();

        $count = Follow::where('followee_id', $id)->count();

        return response([$count]);
    }
}
