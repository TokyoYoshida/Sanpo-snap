@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Photos</div>

                <div class="card-body">
                    <photo-gallery></photo-gallery>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
