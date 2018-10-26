@extends('layouts.app')

@section('content')
    <div class="container photo-edit">
        <form method="POST" action="{{ $photo ? url("photos/edit/update") : url('/photos') }}" aria-label="{{ __('Register') }}">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (session('success'))
                    <div class="container mt-2">
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-0">
                    <div class="card-header border-0">{{ __('写真') }}</div>
                    <div class="card-body text-center">
                        <img src="/storage/photo/{{ $photo->filename  }}" class="preview-img">
                        <fav-panel
                            :default-is-faved={{ json_encode($is_faved) }}
                            :user-id="{{ $auth_user ? $auth_user->id : json_encode(null)}}"
                            :photo-id="{{ $photo->id }}">
                        </fav-panel>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-0">
                    <div class="card-header border-0">{{ __('写真の情報') }}</div>

                    <div class="card-body">
                            @csrf

                            <input type="hidden" class="form-control" name="photo_id" value="{{ $photo ? $photo->id : (session('photo_id') ? session('photo_id') : '')}}">

                            <div class="form-group row">
                                <label for="user" class="col-md-4 col-form-label text-md-right">{{ __('ユーザー') }}</label>

                                <div class="col-md-7 text-left">
                                    <user-panel
                                        :id="{{$photo_user->id}}"
                                        name="{{$photo_user->name}}"
                                        icon-url="{{ asset("storage/avatar/{$photo_user->icon_file}") }}"
                                        :is-following={{ json_encode($is_following != null)}}
                                        :button-type={{ ($auth_user == null || $auth_user->id == $photo_user->id) ? 0 : ($is_following != null ?  2 : 1)}}
                                    >
                                    </user-panel>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('タイトル') }}</label>

                                <div class="col-md-6 d-flex align-items-center">
                                    {{ $photo->title }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="comment" class="col-md-4 col-form-label text-md-right">{{ __('コメント') }}</label>

                                <div class="col-md-6 d-flex align-items-center">
                                    {{ $photo->comment }}
                                </div>
                            </div>

                        <div class="form-group row">
                            <label for="sanpo_date" class="col-md-4 col-form-label text-md-right">{{ __('散歩した日') }}</label>

                            <div class="col-md-6 d-flex align-items-center">
                                {{ $photo->sanpo_date !== null ? $photo->sanpo_date->format('Y年m月d日') : '' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card border-0">
                        <div class="card-header border-0">{{ __('場所') }}</div>
                        <div class="card-body">
                            @if ($photo || old('lat'))
                               <map-pointer :default-maker="{lat: {{old('lat', $photo ? $photo->location_lat : '')}}, lng: {{old('lng', $photo ? $photo->location_lng : '')}} }">
                                </map-pointer>
                            @else
                                <map-pointer></map-pointer>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-0">
                    <div class="card-header border-0">{{ __('コメント') }}</div>

                    <div class="card-body">
                        <comment-panel
                            photo-id="{{ $photo->id }}"
                            :auth-user-id="{{ Auth::user() ? Auth::user()->id : json_encode(null) }}"
                        >
                        </comment-panel>
                    </div>
                </div>
            </div>
        </div>
        @if (($photo_user && Auth::user()) ? Auth::user()->id == $photo_user->id : false)
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-0">
                    <a class="btn btn-primary" href="{{ route('photo_edit', ['id' => $photo->id]) }}">編集する</a>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
