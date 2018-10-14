<?php

namespace App\Http\Controllers;

use App\Photo;
use App\User;
use App\Fav;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ApiUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function photos($id)
    {
        $user = User::find($id);
        $photos = $user->photos()->get();
        return response($photos);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function favs($id)
    {
        $user = User::find($id);
        $favs = $user->favs()->with('photo')->get();

        $photos = [];
        foreach ($favs as $fav) {
            $photos[]= $fav->photo;
        }

        return response($photos);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function timeline($id)
    {
        $photos = DB::table('follows')
            ->select('photos.*')
            ->join('photos', 'follows.followee_id', '=', 'photos.user_id')
            ->where('follows.follower_id', '=', $id)
            ->orderBy('photos.created_at', 'desc')
            ->take(10)
            ->get();

        return response($photos);
    }

    /**
     * add fav photo to user
     *
     * @return \Illuminate\Http\Response
     */
    public function add_fav($id, Request $request)
    {
        $this->validate($request, [
            'photo_id' => ['required']
        ]);

        $user = User::find(auth()->id());
        if($user === null){
            abort(404);
        }

        $photo = Photo::find($request->photo_id);
        if($photo === null){
            abort(404);
        }

        $this->store_fav($id, $request->photo_id);

        return response($request->photo_id);
    }

    /**
     * del fav from user
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function del_fav($id, Request $request)
    {
        $this->validate($request, [
            'photo_id' => ['required']
        ]);

        $user = User::find(auth()->id());
        if($user === null){
            abort(404);
        }

        $photo = Photo::find($request->photo_id);
        if($photo === null){
            abort(404);
        }

        $this->delete_fav($id, $request->photo_id);

        return response($request->photo_id);
    }

    /**
     * store fav
     *
     * @param $id
     * @param $photo_id
     */
    private function store_fav($id, $photo_id)
    {
        $fav = new Fav();
        $fav->user_id = $id;
        $fav->photo_id = $photo_id;
        $fav->save();
    }

    /**
     * delete fav
     *
     * @param $id
     * @param $photo_id
     */
    private function delete_fav($id, $photo_id)
    {
        Fav::where('user_id', '=', $id)->where("photo_id", $photo_id)->delete();
    }
}
