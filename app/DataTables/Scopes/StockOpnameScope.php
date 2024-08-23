<?php

namespace App\DataTables\Scopes;

use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTableScope;

class StockOpnameScope implements DataTableScope
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request  = $request;
    }

    public function apply($query)
    {
        return $query->when($this->request->filled('product_id'), function ($query) {
            $query->whereHas('product', function ($query) {
                $query->where('product_id', $this->request->product_id);
            });
        })
            ->when($this->request->filled('date_range'), function ($query) {
                $dates = explode(' to ', $this->request->date_range);
                if (count($dates) == 2) {
                    $query->whereBetween('created_at', [$dates[0], $dates[1]]);
                }
            });
    }
}
