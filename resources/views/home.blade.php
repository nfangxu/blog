@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ $article->title }}</h3>
                    </div>
                    <div class="card-body markdown">
                        {!! Parsedown::instance()->setMarkupEscaped(true)->text($article->content) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
