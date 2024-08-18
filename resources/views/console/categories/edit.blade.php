@extends('layouts.app')
@section('title', 'Edit Category')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">

            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">
                    <span class="fw-normal">Edit Category</span>
                </h5>
            </div>

            <div class="card-body">
                <div class="offcanvas-body mx-0 flex-grow-0 h-100 mt-2">

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <h4 class="alert-heading d-flex align-items-center">
                                <span class="alert-icon rounded">
                                    <i class="ri-error-warning-line ri-22px"></i>
                                </span>
                                Something went wrong!
                            </h4>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form class="warehouse pt-0" id="warehouseForm" method="POST" onsubmit="return false"
                        action="{{ route('categories.update', $category->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <!-- Category Code -->
                                <div class="form-floating form-floating-outline mb-5 mt-2">
                                    <input type="text" class="form-control @error('code') is-invalid @enderror"
                                        id="warehouse-code" placeholder="Category Code" name="code"
                                        aria-label="Category Code" value="{{ old('code', $category->code) }}" />
                                    <label for="warehouse-code">Category Code</label>
                                    @error('code')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <!-- Category Name -->
                                <div class="form-floating form-floating-outline mb-5 mt-2">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="warehouse-name" placeholder="Category Name" name="name"
                                        aria-label="Category Name" value="{{ old('name', $category->name) }}" />
                                    <label for="warehouse-name">Category Name</label>
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit and Cancel Buttons -->
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/console/categories/category_validation_script.js')
@endpush
