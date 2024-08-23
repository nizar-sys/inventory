<?php

namespace App\Http\Controllers\Console;

use App\DataTables\ProductStockDataTable;
use App\DataTables\Scopes\ProductStockScope;
use App\Enums\StockTypeEnum;
use App\Helpers\EnumHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequestProductStock;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductStockController extends Controller
{
    public function index(ProductStockDataTable $dataTable, Request $request)
    {
        $products = Product::select('id', 'name')
            ->when(Auth::user()->hasRole('Warehouse Admin'), function ($query) {
                $authId = Auth::id();
                $query->whereHas('supplier.branch.workers', function ($query) use ($authId) {
                    $query->where('user_id', $authId);
                });
            })->get();
        $enumTypes = EnumHelper::getEnumByKey(StockTypeEnum::class, [StockTypeEnum::IN, StockTypeEnum::OUT]);


        return $dataTable->addScopes([new ProductStockScope($request)])->render('console.product-stocks.index', compact('products', 'enumTypes'));
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
        $enumTypes = EnumHelper::getEnumByKey(StockTypeEnum::class, [StockTypeEnum::IN, StockTypeEnum::OUT]);

        return view('console.product-stocks.create', compact('products', 'enumTypes'));
    }

    public function store(RequestProductStock $request)
    {
        $validatedData = $request->validated();

        $productId = $validatedData['product_id'];
        $quantity = $validatedData['quantity'];
        $type = $validatedData['type'];

        try {
            DB::transaction(function () use ($productId, $quantity, $type) {
                ProductStock::create([
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'type' => $type,
                ]);

                $product = Product::findOrFail($productId);

                if ($type == EnumHelper::getKey(StockTypeEnum::class, 'IN')) {
                    $product->increment('stock', $quantity);
                } elseif ($type == EnumHelper::getKey(StockTypeEnum::class, 'OUT')) {
                    if ($product->stock < $quantity) {
                        throw new \Exception('Insufficient stock to process the request.');
                    }
                    $product->decrement('stock', $quantity);
                }
            });

            return redirect()->route('stocks.index')->with('success', 'Product Stock created and updated successfully.');
        } catch (\Throwable $e) {
            Log::error('Product Stock creation or update failed: ' . $e->getMessage());

            return back()->withInput()->with('error', 'Failed to create or update Product Stock. Please try again.');
        }
    }

    public function edit(ProductStock $stock)
    {
        $products = Product::select('id', 'name')
            ->when(Auth::user()->hasRole('Warehouse Admin'), function ($query) {
                $authId = Auth::id();
                $query->whereHas('supplier.branch.workers', function ($query) use ($authId) {
                    $query->where('user_id', $authId);
                });
            })->get();
        $enumTypes = EnumHelper::getEnumByKey(StockTypeEnum::class, [StockTypeEnum::IN, StockTypeEnum::OUT]);

        return view('console.product-stocks.edit', compact('products', 'enumTypes', 'stock'));
    }

    public function update(RequestProductStock $request, $id)
    {
        $validatedData = $request->validated();

        $stock = ProductStock::findOrFail($id);

        $product = Product::findOrFail($validatedData['product_id']);

        try {
            DB::transaction(function () use ($stock, $product, $validatedData) {
                $stock->update([
                    'product_id' => $validatedData['product_id'],
                    'quantity' => $validatedData['quantity'],
                    'type' => $validatedData['type'],
                ]);

                if ($validatedData['type'] == EnumHelper::getKey(StockTypeEnum::class, 'IN')) {
                    $product->increment('stock', $validatedData['quantity']);
                } elseif ($validatedData['type'] ==  EnumHelper::getKey(StockTypeEnum::class, 'OUT')) {
                    if ($product->stock < $validatedData['quantity']) {
                        throw new \Exception('Insufficient stock to process the request.');
                    }
                    $product->decrement('stock', $validatedData['quantity']);
                }
            });

            return redirect()->route('stocks.index')->with('success', 'Product Stock updated successfully.');
        } catch (\Throwable $e) {
            Log::error('Product Stock update failed: ' . $e->getMessage());

            return back()->withInput()->with('error', 'Failed to update Product Stock. Please try again.');
        }
    }

    public function destroy(ProductStock $stock)
    {
        try {
            DB::transaction(function () use ($stock) {
                $productModel = $stock->product;

                // Pastikan produk ditemukan
                if (!$productModel) {
                    throw new \Exception('Product not found.');
                }

                // Ambil jumlah stok terakhir dari produk
                $latestStockQuantity = $productModel->stock;

                // Periksa apakah kuantitas yang ingin dihapus tidak melebihi stok yang ada
                if ($stock->type === 'IN' && $latestStockQuantity < $stock->quantity) {
                    throw new \Exception('Cannot delete because the quantity to be removed is greater than the available stock.');
                } elseif ($stock->type === 'OUT' && ($latestStockQuantity + $stock->quantity) < 0) {
                    throw new \Exception('Cannot delete because the resulting stock would be negative.');
                }

                // Update stok produk berdasarkan tipe
                if ($stock->type === 'IN') {
                    $productModel->decrement('stock', $stock->quantity);
                } elseif ($stock->type === 'OUT') {
                    $productModel->increment('stock', $stock->quantity);
                }

                // Hapus stok produk
                $stock->delete();
            });

            return redirect()->route('stocks.index')->with('success', 'Product Stock deleted successfully.');
        } catch (\Throwable $e) {
            // Log kesalahan jika terjadi
            Log::error('Product Stock deletion failed: ' . $e->getMessage());

            return redirect()->route('stocks.index')->with('error', 'Failed to delete Product Stock. Please try again.');
        }
    }
}
