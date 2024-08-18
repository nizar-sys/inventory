<?php

namespace App\DataTables\Scopes;

use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTableScope;

class WarehouseScope implements DataTableScope
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request  = $request;
    }

    public function apply($query)
    {
        return $query->when($this->request->filled('is_active'), function ($query) {
            $query->where('is_active', $this->request->is_active);
        });
    }
}
