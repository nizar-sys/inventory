@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Dashboard Summary Cards -->
        <div class="row g-6">
            <!-- Total Products Card -->
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded-3 bg-label-primary">
                                    <i class="ri-inbox-line ri-24px"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{ $totalProducts }}</h4>
                        </div>
                        <h6 class="mb-0 fw-normal">Total Products</h6>
                    </div>
                </div>
            </div>
            <!-- Total Suppliers Card -->
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded-3 bg-label-warning">
                                    <i class="ri-store-2-line ri-24px"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{ $totalSuppliers }}</h4>
                        </div>
                        <h6 class="mb-0 fw-normal">Total Suppliers</h6>
                    </div>
                </div>
            </div>
            <!-- Total Categories Card -->
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded-3 bg-label-success">
                                    <i class="ri-price-tag-3-line ri-24px"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{ $totalCategories }}</h4>
                        </div>
                        <h6 class="mb-0 fw-normal">Total Categories</h6>
                    </div>
                </div>
            </div>
            <!-- Total Stock Opnames Card -->
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded-3 bg-label-danger">
                                    <i class="ri-file-list-3-line ri-24px"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{ $totalStockOpnames }}</h4>
                        </div>
                        <h6 class="mb-0 fw-normal">Total Stock Opnames</h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Table -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title">Recent Products</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Product Code</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Supplier</th>
                            <th>Stock</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentProducts as $product)
                            <tr>
                                <td>{{ $product->code }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->full_name }}</td>
                                <td>{{ $product->supplier->name }}</td>
                                <td>{{ $product->stock }}</td>
                                <td><img src="{{ $product->image_url }}" alt="{{ $product->name }}" width="50"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Supplier Table -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title">Top Suppliers</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Supplier Name</th>
                            <th>Branch</th>
                            <th>Contact</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topSuppliers as $supplier)
                            <tr>
                                <td>{{ $supplier->name }}</td>
                                <td>{{ $supplier->branch->name }}</td>
                                <td>{{ $supplier->contact }}</td>
                                <td>{{ $supplier->address }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
