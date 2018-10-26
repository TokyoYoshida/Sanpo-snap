<?php

namespace App\Http\Controllers;

use App\Photo;
use App\User;
use Illuminate\Support\Facades\DB;

class ApiPhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return response(Photo::all());
    }

    /**
     * return a comment
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function comments($photo_id) {
        $auth_user = User::find(auth()->id());

        $comments = DB::table('comments')
            ->select('comments.*', 'users.name as user_name', 'users.icon_file as user_icon_file', 'follows.follower_id')
            ->join('users', 'comments.user_id', 'users.id')
            ->leftJoin('follows', function ($join) use ($auth_user) {
                if($auth_user !== null) {
                    $join->on('comments.user_id', '=', 'follows.followee_id')
                        ->where('follower_id', '=', $auth_user->id);
                } else {
                    $join->whereNull('comments.user_id');
                }
            })
            ->where('photo_id', '=', $photo_id)
            ->get();
        if ($comments === null) {
            abort(404);
        }

        \Log::debug('log test', [$comments]);

        return $comments;
    }
}
