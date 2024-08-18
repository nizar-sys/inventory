@extends('layouts.app')
@section('title', 'Edit Warehouse')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">

            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">
                    <span class="fw-normal">Edit Warehouse</span>
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
                        action="{{ route('warehouses.update', $warehouse->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <!-- Warehouse Name -->
                                <div class="form-floating form-floating-outline mb-5 mt-2">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="warehouse-name" placeholder="Warehouse Name" name="name"
                                        aria-label="Warehouse Name" value="{{ old('name', $warehouse->name) }}" />
                                    <label for="warehouse-name">Warehouse Name</label>
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6"><!-- Address -->
                                <div class="form-floating form-floating-outline mb-5 mt-2">
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="warehouse-address" placeholder="Warehouse Address" name="address"
                                        aria-label="Warehouse Address" value="{{ old('address', $warehouse->address) }}" />
                                    <label for="warehouse-address">Address</label>
                                    @error('address')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-6"><!-- City -->
                                <div class="form-floating form-floating-outline mb-5">
                                    <input type="text" class="form-control @error('city') is-invalid @enderror"
                                        id="warehouse-city" placeholder="City" name="city" aria-label="City"
                                        value="{{ old('city', $warehouse->city) }}" />
                                    <label for="warehouse-city">City</label>
                                    @error('city')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6"><!-- State -->
                                <div class="form-floating form-floating-outline mb-5">
                                    <input type="text" class="form-control @error('state') is-invalid @enderror"
                                        id="warehouse-state" placeholder="State" name="state" aria-label="State"
                                        value="{{ old('state', $warehouse->state) }}" />
                                    <label for="warehouse-state">State</label>
                                    @error('state')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-6"><!-- Zip Code -->
                                <div class="form-floating form-floating-outline mb-5">
                                    <input type="text" class="form-control @error('zip_code') is-invalid @enderror"
                                        id="warehouse-zip-code" placeholder="Zip Code" name="zip_code" aria-label="Zip Code"
                                        value="{{ old('zip_code', $warehouse->zip_code) }}" />
                                    <label for="warehouse-zip-code">Zip Code</label>
                                    @error('zip_code')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6"><!-- Country -->
                                <div class="form-floating form-floating-outline mb-5">
                                    <input type="text" class="form-control @error('country') is-invalid @enderror"
                                        id="warehouse-country" placeholder="Country" name="country" aria-label="Country"
                                        value="{{ old('country', $warehouse->country) }}" />
                                    <label for="warehouse-country">Country</label>
                                    @error('country')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-6"><!-- Phone -->
                                <div class="form-floating form-floating-outline mb-5">
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="warehouse-phone" placeholder="Phone" name="phone" aria-label="Phone"
                                        value="{{ old('phone', $warehouse->phone) }}" />
                                    <label for="warehouse-phone">Phone</label>
                                    @error('phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6"><!-- Email -->
                                <div class="form-floating form-floating-outline mb-5">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="warehouse-email" placeholder="Email" name="email" aria-label="Email"
                                        value="{{ old('email', $warehouse->email) }}" />
                                    <label for="warehouse-email">Email</label>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-6"><!-- Is Active -->
                                <div class="form-floating form-floating-outline mb-5">
                                    <select id="warehouse-is-active"
                                        class="form-select @error('is_active') is-invalid @enderror" name="is_active">
                                        <option value="1"
                                            {{ old('is_active', $warehouse->is_active) == 1 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0"
                                            {{ old('is_active', $warehouse->is_active) == 0 ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                    <label for="warehouse-is-active">Status</label>
                                    @error('is_active')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <!-- Submit and Cancel Buttons -->
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                        <a href="{{ route('warehouses.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/console/warehouses/warehouse_validation_script.js')
@endpush
