<?php

namespace App\Http\Controllers\Console;

use App\DataTables\Scopes\WarehouseScope;
use App\DataTables\WarehouseDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequestStoreWarehouse;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\WarehouseWorker;
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
        $workers = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'Administrator');
        })->get();

        return view('console.warehouses.create', compact('workers'));
    }

    public function store(RequestStoreWarehouse $request)
    {
        DB::beginTransaction();

        try {
            $warehouse = Warehouse::create($request->validated());
            WarehouseWorker::create([
                'user_id' => $request->worker,
                'warehouse_id' => $warehouse->id
            ]);

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
        $workers = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'Administrator');
        })->get();

        return view('console.warehouses.edit', compact('warehouse', 'workers'));
    }

    public function update(RequestStoreWarehouse $request, Warehouse $warehouse)
    {
        DB::beginTransaction();

        try {
            $warehouse->update($request->validated());

            if ($request->worker) {
                $worker = WarehouseWorker::where('warehouse_id', $warehouse->id)->first();
                if ($worker) {
                    $worker->update([
                        'user_id' => $request->worker
                    ]);
                } else {
                    WarehouseWorker::create([
                        'user_id' => $request->worker,
                        'warehouse_id' => $warehouse->id
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('warehouses.index')->with('success', 'Warehouse updated successfully.');
        } catch (\Exception $e) {
            dd($e->getMessage());
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
