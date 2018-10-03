<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\User;

class UserEditController extends Controller
{
    /**
     * @var string icon store directory
     */
    private $icon_dir = 'public/avatar';

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(auth()->id());
        if ($user === null) {
            abort(404);
        }

        return view('user_edit', ['user' => $user]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = User::find($request->id);
        $this->validator($user, $request->all())->validate();
        $this->store($user, $request);
        return redirect()->back()->with('success', __('プロフィールを更新しました。'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $target_user = User::find($id);
        if ($target_user === null) {
            abort(404);
        }

        $follows = $target_user->follows->count();
        $followers = $target_user->followers->count();

        $is_following = false;
        $auth_user = User::find(auth()->id());
        if($auth_user !== null) {
            $is_following = $target_user->followers->where('follower_id', $auth_user->id)->first() !== null;
        }

        return view('user_show', [
            'user' => $target_user,
            'follows_count' => $follows,
            'followers_count' => $followers,
            'is_following' => $is_following,
            'auth_user' => $auth_user,
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator($user, array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'comment' => 'string|max:255'
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function store($user, Request $request)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->comment = $request->comment;
        $user->save();
    }

    /**
     * upload a icon file
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => [
                // 必須
                'required',
                // アップロードされたファイルであること
                'file',
                // 画像ファイルであること
                'image',
                // MIMEタイプを指定
                'mimes:jpeg,png',
                // 最小縦横120px 最大縦横400px
                'dimensions:min_width=120,min_height=120,max_width=400,max_height=400',
            ]
        ]);

        $filename = $request->file->store($this->icon_dir);

        $user = User::find(auth()->id());
        if ($user === null) {
            abort(404);
        }
        $old_filename = $user->icon_file;
        $user->icon_file = basename($filename);
        $user->save();
        if (!empty($old_filename)) {
            Storage::delete("{$this->icon_dir}/{$old_filename}");
        }
        return redirect()->back()->with('success', __('アイコン画像を更新しました。'));
    }
}
