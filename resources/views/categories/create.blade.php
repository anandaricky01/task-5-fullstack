@extends('layouts.app')

@section('content')
{{-- <div class="container"> --}}
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    Create Category
                    <a href="/category" class="ms-3 btn btn-danger btn-sm">Back</a>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            @if (session()->has('danger'))
                                <div class="col-sm">
                                    <div class="alert alert-danger" role="alert">{{ session('danger') }}</div>
                                </div>
                            @endif
                            <form method="POST" action="/category">
                                @csrf
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category Name</label>
                                    <input type="text" class="form-control @error('category') is-invalid @enderror" id="category" name="category" value="{{ old('category') }}">
                                    @error('category')
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
