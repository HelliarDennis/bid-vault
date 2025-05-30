<?php

namespace App\Http\Controllers;

use App\Data\ItemCategoryData;
use App\Data\ItemData;
use App\Data\PaginationData;
use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query()
            ->with('category')
            ->when($request->category, function ($query, $category) {
                $query->whereHas('category', function ($q) use ($category) {
                    $q->where('slug', $category);
                });
            })
            ->when($request->status === 'upcoming', function ($query) {
                $query->where('start_at', '>', now());
            })
            ->when($request->status === 'active', function ($query) {
                $query->where('start_at', '<=', now())
                    ->where('end_at', '>', now());
            })
            ->when($request->status === 'ended', function ($query) {
                $query->where('end_at', '<=', now());
            });

        $items = $query->latest()->paginate(8);
        $categories = ItemCategory::all();

        return Inertia::render('Dashboard', [
            'items' => PaginationData::fromPaginator($items, ItemData::class),
            'categories' => ItemCategoryData::collect($categories),
            'currentCategory' => $request->category,
            'currentStatus' => $request->status,
        ]);
    }
}
