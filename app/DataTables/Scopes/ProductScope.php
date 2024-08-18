<?php

namespace App\DataTables\Scopes;

use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTableScope;

class ProductScope implements DataTableScope
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request  = $request;
    }

    public function apply($query)
    {
        return $query->when($this->request->filled('branch_id'), function ($query) {
            $query->whereHas('supplier', function ($query) {
                $query->where('branch_id', $this->request->branch_id);
            });
        })
        ->when($this->request->filled('category_id'), function ($query) {
            $query->where('category_id', $this->request->category_id);
        })
        ->when($this->request->filled('supplier_id'), function ($query) {
            $query->where('supplier_id', $this->request->supplier_id);
        });
    }
}
