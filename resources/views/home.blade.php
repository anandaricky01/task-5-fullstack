@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Home') }}</div>

                <div class="card-body">
                    @if ($articles->count() > 0)
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        Latest Posts
                        <div class="mb-2"></div>
                        <div class="row">
                            <div class="col">
                                <div class="card mb-3">
                                    <img src="{{ asset('img') . "/" . $articles[0]->image }}" class="card-img-top" alt="forget-me-not">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $articles[0]->title }}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">By {{ $articles[0]->user->name }}</h6>
                                    <p class="card-text">{{ Str::limit($articles[0]->content, 50, '...') }}</p>
                                    <p class="card-text"><small class="text-muted">{{ $articles[0]->created_at->diffForHumans() }}</small></p>
                                    <a href="/article/{{ $articles[0]->id }}" class="card-link btn btn-primary btn-sm">Card link</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($articles->skip(1) as $article)
                            @php
                                $i++;
                            @endphp
                            <div class="col-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ Str::limit($article->title, 40, "...") }}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">By {{ $article->user->name }}</h6>
                                        <h6 class="card-subtitle mb-2 text-muted">{{ $article->category->name }}</h6>
                                        <p class="card-text">{{ Str::limit($article->content, 50, "...") }}</p>
                                        <a href="/article/{{ $article->id }}" class="card-link btn btn-primary btn-sm">Card link</a>
                                    </div>
                                </div>
                            </div>
                            @if ($i % 3 == 0)
                                <div class="mb-3"></div>
                            @endif
                            @endforeach
                        </div>
                        <a href="/article" class="mt-3 btn btn-primary">Another Posts</a>
                    @else
                        <div class="row">
                            <div class="col">
                                No Posts Yet
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
