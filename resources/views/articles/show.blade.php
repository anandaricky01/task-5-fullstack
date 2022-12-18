@extends('layouts.app')

@section('content')
{{-- <div class="container"> --}}
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    {{ $article->title }}
                    <a href="/article" class="ms-3 btn btn-secondary btn-sm">Back</a>
                    @if (!auth()->guest())
                        @if ($article->user_id == auth()->user()->id)
                        <a href="/article/{{ $article->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
                        <a class="btn btn-danger btn-sm" href="/article/{{ $article->id }}"
                            onclick="event.preventDefault();
                            document.getElementById('delete').submit();">
                            Delete
                        </a>
                        @endif
                    @endif

                    <form id="delete" action="/article/{{ $article->id }}" method="POST" class="d-none">
                        @csrf
                        @method('delete')
                    </form>
                </div>

                <div class="card-body">
                    @if (session()->has('success'))
                        <div class="col-sm">
                            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                        </div>
                    @endif
                    <a href="">
                        <h5>
                            <div class="badge text-bg-secondary rounded-5">
                                {{ $article->category->name }}
                            </div>
                        </h5>
                    </a>
                    <div class="mb-3"></div>
                    @if ($article->image != NULL)
                        <img src="{{ asset('img') . "/" . $article->image }}" class="img-fluid rounded-2" alt="forget-me-not">
                    @else
                        <img src="{{ asset('img/forget-me-not flower field.png') }}" class="img-fluid rounded-2" alt="forget-me-not">
                    @endif
                    <div class="mb-3"></div>
                    <h6 class="card-subtitle text-muted">Author : {{ $article->user->name }}</h6>
                    <div class="mb-3"></div>
                    <p>{!! $article->content !!}</p>
                </div>
            </div>
        </div>
    </div>
    {{--
</div> --}}
@endsection
