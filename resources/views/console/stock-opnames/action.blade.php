<div class="d-flex align-items-center gap-2">
    <!-- Edit Button -->
    <a href="{{ route('stock-opnames.edit', $id) }}"
        class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect" data-bs-toggle="tooltip" title="Edit">
        <i class="ri-edit-box-line ri-20px"></i>
    </a>

    <!-- Delete Button -->
    <a href="javascript:;" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect delete-record"
        data-id="{{ $id }}" data-bs-toggle="tooltip" title="Delete">
        <i class="ri-delete-bin-7-line ri-20px"></i>
    </a>
</div>
