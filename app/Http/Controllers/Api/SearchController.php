<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = User::find($request->filled("user_id") ? $request->user_id : 1);
        $data = array_merge(
            $this->getPages($user),
            $this->getFiles(),
            $this->getMembers()
        );

        return response()->json($data);
    }

    /**
     * Get the pages data.
     */
    private function getPages($user): array
    {
        $menus = collect();
        $menuWhereRole = config('console-menu'); // admin

        if($user->hasRole('Warehouse Admin')){
            $menuWhereRole = config('console-menu-admin-warehouse'); // warehouse admin
        }

        foreach ($menuWhereRole as $menu) {
            foreach ($menu['items'] as $item) {
                if ($item['route'] == '') {
                    foreach ($item['submenu'] as $subitem) {
                        if ($subitem['route'] == '') {
                            continue;
                        }
                        $menus[] = [
                            'name' => $item['title'] . ' - ' . $subitem['title'],
                            'icon' => $item['icon'],
                            'url' => route($subitem['route'])
                        ];
                    }
                    continue;
                }
                $menus[] = [
                    'name' => $item['title'],
                    'icon' => $item['icon'],
                    'url' => route($item['route'])
                ];
            }
        }

        return [
            'pages' => $menus,
        ];
    }

    /**
     * Get the files data.
     */
    private function getFiles(): array
    {
        $files = collect();
        $userAvatars = User::get()->map(function ($user) {
            $url = $user->avatarUrl;

            $response = Http::head($url);
            $fileSize = $response->header('Content-Length');

            return [
                "name" => "Avatar " . $user->name,
                "subtitle" => "By " . $user->name,
                "src" => $user->avatar,
                "meta" => $this->formatSize($fileSize),
                "url" => $user->avatar,
            ];
        })->toArray();

        $productFiles = Product::select('id', 'name', 'image', 'supplier_id')->get()->map(function ($product) {
            $url = $product->image_url;

            $response = Http::head($url);
            $fileSize = $response->header('Content-Length');

            return [
                "name" => 'Product ' . $product->name,
                "subtitle" => "By " . $product->supplier->name,
                "src" => $product->image,
                "meta" => $this->formatSize($fileSize),
                "url" => $product->image,
            ];
        })->toArray();

        $files = $files->merge($userAvatars, $productFiles);

        return [
            'files' => $files,
        ];
    }

    /**
     * Get the members data.
     */
    private function getMembers(): array
    {
        return [
            'members' => [
                [
                    "name" => "John Doe",
                    "subtitle" => "Admin",
                    "src" => "img/avatars/1.png",
                    "url" => "app-user-view-account.html"
                ],
            ],
        ];
    }

    private function formatSize($bytes): string
    {
        $sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
        if ($bytes == 0) return 'n/a';
        $i = floor(log($bytes, 1024));
        return round($bytes / pow(1024, $i), 2) . ' ' . $sizes[$i];
    }
}
