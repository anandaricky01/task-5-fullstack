@extends('layouts.app')

@section('content')
{{-- <div class="container"> --}}
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">{{ __('All Posts') }} <a class="ms-2 btn btn-success btn-sm" href="/article/create">+ create post</a></div>

                <div class="card-body">
                    @if ($articles->count() > 0)
                        <div class="row">
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($articles as $article)
                            @php
                                $i++;
                            @endphp
                            <div class="col-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ Str::limit($article->title, 40, "...") }}</h5>
                                        <h6 class="card-subtitle text-muted">{{ $article->category->name }}</h6>
                                        <p class="card-text">By {{ $article->user->name }}</p>
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
                        <div class="mt-3">
                            {{ $articles->links() }}
                        </div>
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
{{-- </div> --}}
@endsection
