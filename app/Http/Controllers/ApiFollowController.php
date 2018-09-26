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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function follow($id, Request $request)
    {
        $user = User::find(auth()->id());
        $follow = new Follow();
        $follow->followee_id = $id;
        $follow->follower_id = $user->id;
        $follow->save();

        $count = Follow::where('followee_id', $id)->count();

        return response([$count]);
    }
}
