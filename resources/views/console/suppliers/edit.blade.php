@extends('layouts.app')
@section('title', 'Edit Supplier')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">

            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">
                    <span class="fw-normal">Edit Supplier</span>
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

                    <form class="supplier pt-0" id="supplierForm" method="POST"
                        action="{{ route('suppliers.update', $supplier->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Branch ID -->
                            <div class="col-sm-12 col-md-6">
                                <div class="form-floating form-floating-outline mb-5 mt-2">
                                    <select id="supplier-branch-id"
                                        class="form-select @error('branch_id') is-invalid @enderror" name="branch_id"
                                        aria-label="Branch ID">
                                        <option value="" disabled selected>Select Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"
                                                {{ old('branch_id', $supplier->branch_id) == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="supplier-branch-id">Branch</label>
                                    @error('branch_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Supplier Name -->
                            <div class="col-sm-12 col-md-6">
                                <div class="form-floating form-floating-outline mb-5 mt-2">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="supplier-name" placeholder="Supplier Name" name="name"
                                        aria-label="Supplier Name" value="{{ old('name', $supplier->name) }}" />
                                    <label for="supplier-name">Supplier Name</label>
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Contact -->
                            <div class="col-sm-12 col-md-6">
                                <div class="form-floating form-floating-outline mb-5 mt-2">
                                    <input type="text" class="form-control @error('contact') is-invalid @enderror"
                                        id="supplier-contact" placeholder="Contact" name="contact" aria-label="Contact"
                                        value="{{ old('contact', $supplier->contact) }}" />
                                    <label for="supplier-contact">Contact</label>
                                    @error('contact')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="col-sm-12 col-md-6">
                                <div class="form-floating form-floating-outline mb-5 mt-2">
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="supplier-address" placeholder="Address" name="address" aria-label="Address"
                                        value="{{ old('address', $supplier->address) }}" />
                                    <label for="supplier-address">Address</label>
                                    @error('address')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit and Cancel Buttons -->
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                        <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/console/suppliers/supplier_validation_script.js')
@endpush
