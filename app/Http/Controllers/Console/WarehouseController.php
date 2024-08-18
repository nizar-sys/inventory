<?php

namespace App\Http\Controllers\Console;

use App\DataTables\Scopes\WarehouseScope;
use App\DataTables\WarehouseDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequestStoreWarehouse;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WarehouseController extends Controller
{
    public function index(Request $request, WarehouseDataTable $dataTable)
    {
        return $dataTable
            ->addScope(new WarehouseScope($request))
            ->render('console.warehouses.index');
    }

    public function create()
    {
        return view('console.warehouses.create');
    }

    public function store(RequestStoreWarehouse $request)
    {
        DB::beginTransaction();

        try {
            Warehouse::create($request->validated());

            DB::commit();

            return redirect()->route('warehouses.index')->with('success', 'Warehouse created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating warehouse: ' . $e->getMessage());

            return back()->withInput()->with('error', 'Failed to create warehouse. Please try again.');
        }
    }

    public function edit(Warehouse $warehouse)
    {
        return view('console.warehouses.edit', compact('warehouse'));
    }

    public function update(RequestStoreWarehouse $request, Warehouse $warehouse)
    {
        DB::beginTransaction();

        try {
            $warehouse->update($request->validated());

            DB::commit();

            return redirect()->route('warehouses.index')->with('success', 'Warehouse updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating warehouse: ' . $e->getMessage());

            return back()->withInput()->with('error', 'Failed to update warehouse. Please try again.');
        }
    }

    public function destroy(Warehouse $warehouse)
    {
        DB::beginTransaction();

        try {
            $warehouse->delete();

            DB::commit();

            return redirect()->route('warehouses.index')->with('success', 'Warehouse deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting warehouse: ' . $e->getMessage());

            return back()->with('error', 'Failed to delete warehouse. Please try again.');
        }
    }
}
