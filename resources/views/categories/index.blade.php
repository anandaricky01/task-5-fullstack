@extends('layouts.app')

@section('content')
{{-- <div class="container"> --}}
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    All Categories
                    @if (!auth()->guest())
                    <a class="ms-2 btn btn-success btn-sm" href="/category/create">+ create category</a>
                    @endif
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            @if (session()->has('success'))
                            <div class="col-sm">
                                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        @if ($categories->count() > 0)
                        @php
                        $i = 0;
                        @endphp
                        @foreach ($categories as $category)
                        @php
                        $i++;
                        @endphp
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $category->name }}</h5>
                                    <p class="card-text">Created by {{ $category->user->name }}</p>
                                    @if (!Auth::guest())
                                    @if (Auth::user()->id == $category->user_id)
                                    <a href="/category/{{ $category->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
                                    <a class="btn btn-danger btn-sm" href="/category/{{ $category->id }}" onclick="event.preventDefault();
                                                     document.getElementById('delete-category').submit();">
                                        Delete
                                    </a>

                                    <form id="delete-category" action="/category/{{ $category->id }}" method="POST"
                                        class="d-none">
                                        @csrf
                                        @method('delete')
                                    </form>
                                    @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if ($i % 3 == 0)
                        <div class="mb-3"></div>
                        @endif
                        @endforeach

                        <div class="mt-3">
                            {{ $categories->links() }}
                        </div>
                        @else
                        <div class="row">
                            <div class="col">
                                No Category Yet
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--
</div> --}}
@endsection
