<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Photo;
use Illuminate\Support\Facades\Session;

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
        return redirect()->route("photo_edit", $photo->id)->with('success', __('写真を更新しました。'));
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
    public function destroy(Request $request, $photo_id)
    {
        $auth_user = User::find(auth()->id());
        if($auth_user === null){
            abort(404);
        }
        $photo = Photo::find($photo_id);
        if($auth_user->id !== $photo->user_id){
            abort(404);
        }
        $photo->delete();

        return redirect()->route("photo_create")->with('success', __('写真を削除しました。'));
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
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'comment' => 'string|max:255|nullable',
            'sanpo_date' => 'date|nullable',
            'image_filename' => 'required',
            'lat' => 'required'
        ]);

        return $validator;
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
            if ($photo->filename !== null) { // remove old image if exist
                Storage::delete($this->build_image_path($photo->filename));
            }

            Storage::move($this->build_tmp_path($request->image_filename), $this->build_image_path($request->image_filename));
            $photo->filename = $request->image_filename;
        }

        $photo->user_id = $user_id;
        $photo->title = $request->title;
        $photo->comment = $request->comment;
        $photo->sanpo_date = $request->sanpo_date;
        $photo->location_lat = $request->lat;
        $photo->location_lng = $request->lng;
        $photo->save();
    }

    /**
     * @param $filename
     */
    private function build_image_path($filename) {
        return "public/{$this->photo_dir}/{$filename}";
    }

    /**
     * @param $filename
     */
    private function build_tmp_path($filename) {
        $tmp_dir = config('app.image_tmp_dir');
        return "{$tmp_dir}/{$filename}";
    }
}
