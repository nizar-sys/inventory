<?php

namespace App\Http\Controllers\Console;

use App\DataTables\ProductDataTable;
use App\DataTables\Scopes\ProductScope;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequestStoreProduct;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request, ProductDataTable $dataTable)
    {
        $branches = Warehouse::select('id', 'name')->get();
        $categories = Category::select('id', 'code', 'name')->get();
        $suppliers = Supplier::select('id', 'name')->get();

        return $dataTable
            ->addScope(new ProductScope($request))
            ->render('console.products.index', compact('branches', 'categories', 'suppliers'));
    }

    public function create()
    {
        $categories = Category::select('id', 'code', 'name')->get();
        $suppliers = Supplier::select('id', 'name')->get();

        return view('console.products.create', compact('categories', 'suppliers'));
    }

    public function store(RequestStoreProduct $request)
    {
        $validatedData = $request->validated();

        DB::beginTransaction();

        try {
            if ($request->hasFile('image')) {
                $imagePath = handleUpload('image', '/products');
                $validatedData['image'] = $imagePath;
            }

            Product::create($validatedData);

            DB::commit();

            return redirect()->route('products.index')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Product creation failed: ' . $e->getMessage());

            return back()->withInput()->with('error', 'Failed to create product. Please try again.');
        }
    }

    public function edit(Product $product)
    {
        $categories = Category::select('id', 'code', 'name')->get();
        $suppliers = Supplier::select('id', 'name')->get();

        return view('console.products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(RequestStoreProduct $request, Product $product)
    {
        $validatedData = $request->validated();

        DB::beginTransaction();

        try {
            if ($request->hasFile('image')) {
                $imagePath = handleUpload('image', '/products', $product->image ?? null);
                $validatedData['image'] = $imagePath;
            }

            $product->update($validatedData);

            DB::commit();

            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Product update failed: ' . $e->getMessage());

            return back()->withInput()->with('error', 'Failed to update product. Please try again.');
        }
    }

    public function destroy(Product $product)
    {
        DB::beginTransaction();

        try {
            deleteFileIfExist($product->image);
            $product->delete();

            DB::commit();

            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Product deletion failed: ' . $e->getMessage());

            return back()->with('error', 'Failed to delete product. Please try again.');
        }
    }
}
