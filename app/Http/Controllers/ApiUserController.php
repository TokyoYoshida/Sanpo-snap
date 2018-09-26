<?php

namespace App\Http\Controllers;

use App\Photo;
use App\User;
use App\Fav;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
}
