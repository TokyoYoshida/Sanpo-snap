<?php

namespace App\Http\Controllers;

use App\Photo;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ApiPhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $offset = $request->query("offset");
        $per_page = $request->query("per_page");

        return response(Photo::orderBy('created_at', 'desc')->skip($offset)->take($per_page)->get());
    }

    /**
     * return a photo
     *
     * @return \Illuminate\Http\Response
     */
    public function get($id, Request $request) {
        $auth_user = User::find(auth()->id());
        $photo = Photo::find($id);
        $photo_user = $photo->user()->first();
        if($photo === null){
            abort(404);
        }
        $is_faved = false;
        $is_following = false;
        if($auth_user !== null) {
        $is_faved = $auth_user->favs()->where('photo_id', $photo->id)->first() != null;
        $is_following = $photo_user->followers->where('follower_id', $auth_user->id)->first() !== null;
}

        return response([
            'photo' => $photo,
            'photo_user' => $photo_user,
            'is_faved' => $is_faved,
            'is_following' => $is_following
        ]);
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

        return $comments;
    }
}
