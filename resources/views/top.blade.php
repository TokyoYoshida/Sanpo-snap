@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <photo-gallery :per-page=30></photo-gallery>
    </div>
</div>
@endsection
