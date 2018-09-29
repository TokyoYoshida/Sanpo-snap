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
                        <img src="/storage/photo/{{ $photo->filename  }}">
                        <fav-panel
                            :default-is-faved={{ json_encode($is_faved) }}
                            user-id="{{ $user->id }}"
                            photo-id="{{ $photo->id }}">
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

                            <input type="hidden" class="form-control" name="user_id" value="{{ $user->id }}">
                            <input type="hidden" class="form-control" name="photo_id" value="{{ $photo ? $photo->id : (session('photo_id') ? session('photo_id') : '')}}">

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
        @if (Auth::user()->id == $user->id)
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
