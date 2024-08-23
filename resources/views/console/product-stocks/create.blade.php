@extends('layouts.app')
@section('title', 'Create Product Stocks')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">
                    <span class="fw-normal">Add Product Stock</span>
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

                    <form class="product pt-0" id="product-stock-form" method="POST" enctype="multipart/form-data"
                        action="{{ route('stocks.store') }}">
                        @csrf

                        <div class="row">
                            <!-- Choose Product -->
                            <div class="col-sm-12 col-md-6 mt-2">
                                <div class="form-floating form-floating-outline">
                                    <select class="form-select @error('product_id') is-invalid @enderror" id="product-id"
                                        name="product_id">
                                        <option value="" selected>Choose Product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="product-id">Product</label>
                                    @error('product_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Type Stocks -->
                            <div class="col-sm-12 col-md-6 mt-2">
                                <div class="form-floating form-floating-outline">
                                    <select class="form-select @error('type') is-invalid @enderror" id="type"
                                        name="type">
                                        <option value="" selected>Type</option>
                                        @foreach ($enumTypes as $type)
                                            <option value="{{ $type }}"
                                                {{ old('type') == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="type">Type</label>
                                    @error('type')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Quantity -->
                            <div class="col-sm-12 col-md-6">
                                <div class="form-floating form-floating-outline mb-5 mt-2">
                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                        id="quantity" placeholder="Product Quantity" name="quantity"
                                        aria-label="Product quantity" value="{{ old('quantity') }}" />
                                    <label for="quantity">Product Quantity</label>
                                    @error('quantity')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit and Cancel Buttons -->
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                        <a href="{{ route('stocks.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/console/product-stocks/create_script.js')
@endpush
