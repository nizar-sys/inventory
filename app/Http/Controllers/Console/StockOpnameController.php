<?php

namespace App\Http\Controllers\Console;

use App\DataTables\Scopes\StockOpnameScope;
use App\DataTables\StockOpnameDataTable;
use App\Enums\StockTypeEnum;
use App\Helpers\EnumHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequestStockOpname;
use App\Models\Product;
use App\Models\StockOpname;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockOpnameController extends Controller
{
    public function index(StockOpnameDataTable $dataTable, Request $request)
    {
        $products = Product::select('id', 'name')
            ->when(Auth::user()->hasRole('Warehouse Admin'), function ($query) {
                $authId = Auth::id();
                $query->whereHas('supplier.branch.workers', function ($query) use ($authId) {
                    $query->where('user_id', $authId);
                });
            })->get();
        $enumTypes = EnumHelper::getEnumByKey(StockTypeEnum::class, [StockTypeEnum::IN, StockTypeEnum::OUT]);

        return $dataTable->addScopes([new StockOpnameScope($request)])->render('console.stock-opnames.index', compact('products', 'enumTypes'));
    }

    public function create()
    {
        $products = Product::select('id', 'name')
            ->when(Auth::user()->hasRole('Warehouse Admin'), function ($query) {
                $authId = Auth::id();
                $query->whereHas('supplier.branch.workers', function ($query) use ($authId) {
                    $query->where('user_id', $authId);
                });
            })->get();
        return view('console.stock-opnames.create', compact('products'));
    }

    public function store(RequestStockOpname $request)
    {
        try {
            DB::transaction(function () use ($request) {
                StockOpname::create($request->validated());
            });

            return redirect()->route('stock-opnames.index')->with('success', 'Stock opname created successfully.');
        } catch (\Throwable $e) {
            Log::error('Stock Opname creation failed: ' . $e->getMessage());

            return redirect()->route('stock-opnames.index')->with('error', 'Failed to create stock opname. Please try again.');
        }
    }
}
