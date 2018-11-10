@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('メール認証をお願いします') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('新しい確認メールをメールアドレスに送信されました。') }}
                        </div>
                    @endif

                    {{ __('サービスを使う前に、メール認証をする必要があります。') }}
                    {{ __('もしメールが届いていない場合は') }}、 <a href="{{ route('verification.resend') }}">{{ __('このリンクを押すと再送信されます。') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
