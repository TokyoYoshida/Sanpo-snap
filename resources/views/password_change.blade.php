@extends('layouts.app')

@section('content')
    <div class="container">
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
                <div class="card">
                    <div class="card-header">{{ __('パスワード変更') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('password_change_update') }}" aria-label="{{ __('Register') }}">
                            @csrf

                            <input type="hidden" class="form-control" name="id" value="{{ $user->id }}">

                            <div class="form-group row">
                                <label for="password_old" class="col-md-4 col-form-label text-md-right">{{ __('現在のパスワード') }}</label>

                                <div class="col-md-6">
                                    <input id="password_old" type="password" class="form-control{{ $errors->has('password_old') ? ' is-invalid' : '' }}" name="password_old" required autofocus>

                                    @if ($errors->has('password_old'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password_old') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password_new" class="col-md-4 col-form-label text-md-right">{{ __('新しいパスワード') }}</label>

                                <div class="col-md-6">
                                    <input id="password_new" type="password" class="form-control{{ $errors->has('password_new') ? ' is-invalid' : '' }}" name="password_new" required>

                                    @if ($errors->has('password_new'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password_new') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password_new_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('新しいパスワード（確認）') }}</label>

                                <div class="col-md-6">
                                    <input id="password_new_confirmation" type="password" class="form-control{{ $errors->has('password_new_confirmation') ? ' is-invalid' : '' }}" name="password_new_confirmation" required>

                                    @if ($errors->has('password_new_confirmation'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password_new_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('変更') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
