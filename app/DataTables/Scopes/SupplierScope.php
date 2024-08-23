<?php

namespace App\DataTables\Scopes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Contracts\DataTableScope;

class SupplierScope implements DataTableScope
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request  = $request;
    }

    public function apply($query)
    {
        return $query->when($this->request->filled('branch_id'), function ($query) {
            $query->where('branch_id', $this->request->branch_id);
        })->when(Auth::user()->hasRole('Warehouse Admin'), function ($query) {
            $authId = Auth::id();
            $query->whereHas('branch.workers', function ($query) use ($authId) {
                $query->where('user_id', $authId);
            });
        });
    }
}
