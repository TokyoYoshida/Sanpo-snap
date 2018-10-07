<?php

namespace App\Http\Controllers;

use App\ResignHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use App\SocialAccountService;

class ResignController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show() {
        $auth_user = User::find(auth()->id());
        if ($auth_user === null) {
            abort(404);
        }

        return view('resign', [
            'user' => $auth_user
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function complete() {
        return view('resign', [
            'user' => null
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $auth_user = User::find(auth()->id());
        if ($auth_user === null) {
            abort(404);
        }

        $this->logout($request);
        $this->remove($auth_user);

        return redirect()->route("resign_complete_show")->with('success', __('退会処理が完了しました。'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function remove($user)
    {
        DB::transaction(function () use ($user) {
            ResignHistory::create([
                "user_id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "password" => $user->password,
                "icon_file" => $user->icon_file,
                "comment" => $user->comment,
            ]);
            SocialAccountService::delete($user);
            $user->delete();
        });
    }
}
