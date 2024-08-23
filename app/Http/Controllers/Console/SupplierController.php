<?php

namespace App\Http\Controllers\Console;

use App\DataTables\Scopes\SupplierScope;
use App\DataTables\SupplierDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequestStoreSupplier;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SupplierController extends Controller
{
    public function index(Request $request, SupplierDataTable $dataTable)
    {
        $branches = Warehouse::select('id', 'name', 'is_active')->active()
            ->when(Auth::user()->hasRole('Warehouse Admin'), function ($query) {
                $authId = Auth::id();
                $query->whereHas('workers', function ($query) use ($authId) {
                    $query->where('user_id', $authId);
                });
            })
            ->get();

        return $dataTable
            ->addScope(new SupplierScope($request))
            ->render('console.suppliers.index', compact('branches'));
    }

    public function create()
    {
        $branches = Warehouse::select('id', 'name', 'is_active')->active()
            ->when(Auth::user()->hasRole('Warehouse Admin'), function ($query) {
                $authId = Auth::id();
                $query->whereHas('workers', function ($query) use ($authId) {
                    $query->where('user_id', $authId);
                });
            })->get();

        return view('console.suppliers.create', compact('branches'));
    }
    public function store(RequestStoreSupplier $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validated();

            Supplier::create($validatedData);

            DB::commit();

            return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully');
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Failed to create supplier', ['error' => $e->getMessage()]);

            return back()->withInput()->with('error', 'Failed to create supplier');
        }
    }

    public function edit(Supplier $supplier)
    {
        $branches = Warehouse::select('id', 'name', 'is_active')->active()
            ->when(Auth::user()->hasRole('Warehouse Admin'), function ($query) {
                $authId = Auth::id();
                $query->whereHas('workers', function ($query) use ($authId) {
                    $query->where('user_id', $authId);
                });
            })
            ->get();

        return view('console.suppliers.edit', compact('supplier', 'branches'));
    }

    public function update(RequestStoreSupplier $request, Supplier $supplier)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validated();

            $supplier->update($validatedData);

            DB::commit();

            return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully');
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Failed to update supplier', ['error' => $e->getMessage()]);

            return back()->withInput()->with('error', 'Failed to update supplier');
        }
    }

    public function destroy(Supplier $supplier)
    {
        DB::beginTransaction();

        try {
            $supplier->delete();

            DB::commit();

            return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Failed to delete supplier', ['error' => $e->getMessage()]);

            return back()->with('error', 'Failed to delete supplier');
        }
    }
}
