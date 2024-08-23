@extends('layouts.app')
@section('title', 'Product Stocks')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">Filters</h5>
                <div class="d-flex justify-content-start align-items-center row gx-5 pt-4 gap-5 gap-md-0">
                    <div class="col-md-4 product_filter">
                        <select id="product_filter" class="form-select" data-filter="role" name="product_filter">
                            <option value="">All Products</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 type_filter">
                        <select id="type_filter" class="form-select" data-filter="role" name="type_filter">
                            <option value="">All Types</option>
                            @foreach ($enumTypes as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
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
        var urlDelete = "{{ route('stocks.destroy', ':id') }}";
    </script>
    @vite('resources/js/console/product-stocks/script.js')
@endpush
