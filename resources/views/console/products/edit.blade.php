@extends('layouts.app')
@section('title', 'Edit Product')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">

            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">
                    <span class="fw-normal">Edit Product</span>
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

                    <form class="product pt-0" id="productForm" method="POST" enctype="multipart/form-data"
                        action="{{ route('products.update', $product->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Product Code -->
                            <div class="col-sm-12 col-md-6">
                                <div class="form-floating form-floating-outline mb-5 mt-2">
                                    <input type="text" class="form-control @error('code') is-invalid @enderror"
                                        id="product-code" placeholder="Product Code" name="code"
                                        aria-label="Product Code" value="{{ old('code', $product->code) }}" />
                                    <label for="product-code">Product Code</label>
                                    @error('code')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Product Name -->
                            <div class="col-sm-12 col-md-6">
                                <div class="form-floating form-floating-outline mb-5 mt-2">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="product-name" placeholder="Product Name" name="name"
                                        aria-label="Product Name" value="{{ old('name', $product->name) }}" />
                                    <label for="product-name">Product Name</label>
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Category -->
                            <div class="col-sm-12 col-md-6">
                                <div class="form-floating form-floating-outline mb-5">
                                    <select class="form-select @error('category_id') is-invalid @enderror"
                                        id="product-category" name="category_id">
                                        <option value="" selected>Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="product-category">Category</label>
                                    @error('category_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Supplier -->
                            <div class="col-sm-12 col-md-6">
                                <div class="form-floating form-floating-outline mb-5">
                                    <select class="form-select @error('supplier_id') is-invalid @enderror"
                                        id="product-supplier" name="supplier_id">
                                        <option value="" selected>Select Supplier</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}"
                                                {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="product-supplier">Supplier</label>
                                    @error('supplier_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Image -->
                            <div class="col-sm-12 col-md-6">
                                <div class="form-floating form-floating-outline mb-5">
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        id="product-image" name="image" aria-label="Image" accept=".jpeg, .jpg, .png" />
                                    <label for="product-image">Image</label>
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @if ($product->image)
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-floating form-floating-outline mb-5">
                                        <img src="{{ $product->image_url }}" alt="Product Image"
                                            class="img-fluid rounded" style="max-height: 200px" />

                                        <label for=""><b class="text-danger">Current Image</b></label>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Submit and Cancel Buttons -->
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/console/products/edit_script.js')
@endpush
