<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;

class PasswordChangeController extends Controller
{
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

        return view('password_change', [
            'user' => $auth_user
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

        $this->validator($auth_user, $request->all())->validate();
        $this->store($auth_user, $request);
        return redirect()->back()->with('success', __('パスワードを更新しました。'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator($user, array $data) {
        $validator = Validator::make($data, [
            'password_old' => 'required|string|min:6',
            'password_new' => 'required|string|min:6|confirmed',
            'password_new_confirmation' => 'required|string|min:6',
        ]);

        $validator->after(function ($validator) use ($user, $data) {
            if (!Hash::check($data["password_old"], $user->password)) {
                $validator->errors()->add('password_old', 'パスワードが正しくありません');
            }
        });

        return $validator;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function store($user, Request $request)
    {
        $user->password = Hash::make($request->password_new);
        $user->save();
    }
}
