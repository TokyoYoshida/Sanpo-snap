@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Profile') }}</div>

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
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Follow') }}</div>
                    <div class="form-group row">
                        <label for="comment" class="col-md-4 col-form-label text-md-right">{{ __('フォロー数') }}</label>

                        <div class="col-md-6 d-flex align-items-center">
                            <a href={{ route('follows_show', $user->id) }}>
                                {{ $follows_count }}
                            </a>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="comment" class="col-md-4 col-form-label text-md-right">{{ __('フォロワー数') }}</label>

                        <div class="col-md-6 d-flex align-items-center">
                            <follow-panel
                                :default-followers={{ $followers_count }}
                                :user-id="{{ $user->id }}"
                                :is-following={{ json_encode($is_following) }}
                                :button-type={{ ($auth_user == null || $auth_user->id == $user->id) ? 0 : ($is_following ?  2 : 1)}}
                            >
                            </follow-panel>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Photo') }}</div>
                    <div class="card-body">
                        <photo-gallery type="1" user_id="{{ $user->id }}"></photo-gallery>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Fav') }}</div>
                    <div class="card-body">
                        <photo-gallery type="2" user_id="{{ $user->id }}"></photo-gallery>
                    </div>
                </div>
            </div>
        </div>
@endsection
