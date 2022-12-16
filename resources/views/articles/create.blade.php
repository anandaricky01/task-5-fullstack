@extends('layouts.app')

@section('content')
{{-- <div class="container"> --}}
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    Create Article
                    <a href="/article" class="ms-3 btn btn-danger btn-sm">Back</a>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            @if (session()->has('danger'))
                                <div class="col-sm">
                                    <div class="alert alert-danger" role="alert">{{ session('danger') }}</div>
                                </div>
                            @endif
                            <form method="POST" action="/article" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
                                    @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="title" class="form-label">Category</label>
                                    <select class="form-select @error('category') is-invalid @enderror" aria-label="Default select example" name="category">
                                        <option></option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="form-label @error('content') is-invalid @enderror">content</label>
                                    <textarea class="form-control" name="content" id="content" cols="30" rows="10">{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="formFile" class="form-label @error('image') is-invalid @enderror">Image</label>
                                    <input class="form-control" type="file" id="formFile" name="image">
                                    @error('image')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                              </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--
</div> --}}
@endsection
