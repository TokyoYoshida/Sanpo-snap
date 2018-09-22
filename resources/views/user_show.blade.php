@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('プロフィール') }}</div>

                    <div class="card-body">
                        <div class="form-group row">
                            <label for="icon" class="col-md-4 col-form-label d-flex align-items-center justify-content-end">{{ __('アイコン') }}</label>

                            <div class="col-md-6">
                                <img src="{{ asset("storage/avatar/{$user->icon_file}") }}" alt="avatar" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('ユーザーネーム') }}</label>

                            <div class="col-md-6 d-flex align-items-center">
                                {{ $user->name }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="comment" class="col-md-4 col-form-label text-md-right">{{ __('コメント') }}</label>

                            <div class="col-md-6 d-flex align-items-center">
                                {{ $user->comment }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
