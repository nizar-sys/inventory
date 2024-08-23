<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockOpname;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $authId = $user->id;
        $hasRole = $user->hasRole('Warehouse Admin');

        // Define common query scope if the user has the role
        $adminScope = function ($query) use ($authId) {
            $query->whereHas('supplier.branch.workers', function ($query) use ($authId) {
                $query->where('user_id', $authId);
            });
        };

        $totalProducts = Product::when($hasRole, $adminScope)->count();
        $totalSuppliers = Supplier::when($hasRole, function ($query) use ($authId) {
            $query->whereHas('branch.workers', function ($query) use ($authId) {
                $query->where('user_id', $authId);
            });
        })->count();
        $totalCategories = Category::count();
        $totalStockOpnames = StockOpname::when($hasRole, function ($query) use ($authId) {
            $query->whereHas('product.supplier.branch.workers', function ($query) use ($authId) {
                $query->where('user_id', $authId);
            });
        })->count();

        $recentProducts = Product::when($hasRole, $adminScope)
            ->with('category', 'supplier')
            ->latest()
            ->take(5)
            ->get();

        $topSuppliers = Supplier::with('branch')
            ->when($hasRole, function ($query) use ($authId) {
                $query->whereHas('branch.workers', function ($query) use ($authId) {
                    $query->where('user_id', $authId);
                });
            })
            ->orderBy('name', 'asc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalSuppliers',
            'totalCategories',
            'totalStockOpnames',
            'recentProducts',
            'topSuppliers'
        ));
    }
}
