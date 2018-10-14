@extends('layouts.app')

@section('content')
    <div class="container">
        <home-panel
            user_id="{{ Auth::user()->id }}"
        >
        </home-panel>
    </div>
@endsection
