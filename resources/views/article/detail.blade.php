@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ $article->title }}</h3>
                    </div>
                    <div class="card-body markdown">
                        @if($article->content_html)
                            {!! $article->content_html !!}
                        @else
                            {!! Parsedown::instance()->setMarkupEscaped(true)->text($article->content) !!}
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row col-md-10">
                    <h4>内容推荐</h4>
                </div>
                <div class="row col-md-10">
                    @foreach($articles as $article)
                        <a href="/{{$article->id}}">{{$article->title}}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
