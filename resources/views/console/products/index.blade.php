@extends('layouts.app')
@section('title', 'Products')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">

            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">Filters</h5>
                <div class="d-flex justify-content-between align-items-center row gx-5 pt-4 gap-5 gap-md-0">
                    <div class="col-md-4 branch_id_filter">
                        <select id="branch_id_filter" class="form-select" data-filter="role" name="branch_id_filter">
                            <option value="">All Branch</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 category_id_filter">
                        <select id="category_id_filter" class="form-select" data-filter="role" name="category_id_filter">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 supplier_id_filter">
                        <select id="supplier_id_filter" class="form-select" data-filter="role" name="supplier_id_filter">
                            <option value="">All Suppliers</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-datatable table-responsive">
                {{ $dataTable->table(['class' => 'datatables-permissions table']) }}
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
    <script>
        var urlDelete = "{{ route('products.destroy', ':id') }}";
    </script>
    @vite('resources/js/console/products/script.js')
@endpush
