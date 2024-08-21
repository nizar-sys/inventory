@extends('layouts.app')
@section('title', 'Stock Opnames')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">Filters</h5>
                <div class="d-flex justify-content-start align-items-center row gx-5 pt-4 gap-5 gap-md-0">
                    <div class="col-md-4 product_filter">
                        <select id="product_filter" class="form-select" name="product_filter">
                            <option value="">All Products</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 date_filter">
                        <input type="text" id="date_range" class="form-control" name="date_range"
                            placeholder="Select Date Range">
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
        var urlDelete = "{{ route('stock-opnames.destroy', ':id') }}";
    </script>
    @vite('resources/js/console/stock-opnames/script.js')
@endpush
