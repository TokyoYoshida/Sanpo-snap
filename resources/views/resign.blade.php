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

        <div class="row justify-content-center text">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('退会') }}</div>

                    <div class="card-body text-center">
                        <form method="POST" action="{{ route('resign_update') }}" aria-label="{{ __('Resign') }}">
                            @csrf

                            <button type="submit" class="btn btn-primary">
                                {{ __('退会する') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
