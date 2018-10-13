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
            <div class="col-md-6">
                <div class="card border-0">
                    <div class="card-header border-0">{{ __('写真') }}</div>
                    <div class="card-body">
                        <image-uploader
                            default-filename="{{  old('image_filename', $photo ? $photo->filename : '') }}"
                            image-uploaded="{{ session('success') ? '0' : old('image_uploaded', '0') }}"
                            image-dir="{{ $image_dir }}"
                            :add-remove-link=false
                        >
                        </image-uploader>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0">
                    <div class="card-header border-0">{{ __('写真の情報') }}</div>

                    <div class="card-body">
                            @csrf

                            <input type="hidden" class="form-control" name="user_id" value="{{ $user->id }}">
                            <input type="hidden" class="form-control" name="photo_id" value="{{ $photo ? $photo->id : (session('photo_id') ? session('photo_id') : '')}}">

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('タイトル') }}</label>

                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title', $photo ? $photo->title : '') }}" required autofocus>

                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="comment" class="col-md-4 col-form-label text-md-right">{{ __('コメント') }}</label>

                                <div class="col-md-6">
                                    <input id="comment" type="comment" class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}" name="comment" value="{{ old('comment', $photo ? $photo->comment : '') }}">

                                    @if ($errors->has('comment'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('comment') }}</strong>
                                    </span>
                                    @endif
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
                               <map-pointer :use-search=true :default-maker="{lat: {{old('lat', $photo ? $photo->location_lat : '')}}, lng: {{old('lng', $photo ? $photo->location_lng : '')}} }">
                                </map-pointer>
                            @else
                                <map-pointer :use-search=true></map-pointer>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        <div class="form-group row justify-content-center">
            <div class="col-md-12">
                <div class="card border-0">
                    <button type="submit" class="btn btn-primary">
                        {{ __('保存') }}
                    </button>
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection
