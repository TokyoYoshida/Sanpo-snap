<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Photo;


class PhotoController extends Controller
{
    /**
     * @var string icon store directory
     */
    private $photo_dir = 'photo';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::find(auth()->id());
        if($user === null){
            abort(404);
        }

        $upload_dir = "/storage/{$this->photo_dir}";

        return view('photo_edit', [
                'user' => $user,
                'photo' => null,
                'image_dir' => '/storage/' . $this->photo_dir . '/',
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find($request->user_id);
        $this->validator($request->all())->validate();
        $photo = new Photo();
        $this->save($user->id, $photo, $request);
        return redirect()
            ->back()
            ->withInput()
            ->with(['success' => __("写真を更新しました。" ) ,'photo_id' => $photo->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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

        return view('photo_show', [
                'auth_user' => $auth_user,
                'photo' => $photo,
                'photo_user' => $photo_user,
                'is_faved' => $is_faved,
                'is_following' => $is_following
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find(auth()->id());
        if($user === null){
            abort(404);
        }
        $photo = Photo::find($id);
        if($photo === null){
            abort(404);
        }

        return view('photo_edit', [
                'user' => $user,
                'photo' => $photo,
                'image_dir' => '/storage/' . $this->photo_dir . '/',
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = User::find($request->user_id);
        $this->validator($request->all())->validate();
        $photo = Photo::find($request->photo_id);
        $this->save($user->id, $photo, $request);
        return redirect()->back()->with('success', __('写真を更新しました。'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param $user
     * @param array $data
     * @return mixed
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => 'required|string|max:255',
            'comment' => 'string|max:255|nullable',
            'image_filename' => 'required',
            'lat' => 'required'
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function save($user_id, $photo, Request $request)
    {
        if($request->image_uploaded === "1"){
            $tmp_dir = config('app.image_tmp_dir');
            Storage::move("{$tmp_dir}/{$request->image_filename}", "public/{$this->photo_dir}/{$request->image_filename}");
            $photo->filename = $request->image_filename;
        }

        $photo->user_id = $user_id;
        $photo->title = $request->title;
        $photo->comment = $request->comment;
        $photo->location_lat = $request->lat;
        $photo->location_lng = $request->lng;
        $photo->save();
    }
}
