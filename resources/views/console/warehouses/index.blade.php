@extends('layouts.app')
@section('title', 'Warehouses')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">

            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">Filters</h5>
                <div class="d-flex justify-content-between align-items-center row gx-5 pt-4 gap-5 gap-md-0">
                    <div class="col-md-4 is_active_filter">
                        <select id="is-active-filter" class="form-select" data-filter="role" name="is_active_filter">
                            <option value="">All Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
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
        var urlDelete = `{{ route('warehouses.destroy', ':id') }}`;
    </script>
    @vite('resources/js/console/warehouses/script.js')
@endpush
