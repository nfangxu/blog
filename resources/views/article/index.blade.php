@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row">
                    @foreach($articles as $article)
                        <div class="col-md-8 h5">
                            <a href="/{{$article->id}}">{{$article->title}}</a>
                        </div>
                        <div class="col-md-4">
                            @foreach($article->tags as $tag)
                                <span class="tag"><a href="/tag/{{$tag->id}}">{{$tag->name}}</a></span>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
