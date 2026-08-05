<?php

namespace App\Http\Controllers;

use App\Models\Insight;
use App\Models\InsightCategory;
use Illuminate\View\View;

class InsightController extends Controller
{
    public function index(): View
    {
        $insights = Insight::query()
            ->with(['category', 'user'])
            ->published()
            ->latest('published_at')
            ->latest('id')
            ->paginate(12);

        $categories = InsightCategory::query()->orderBy('name')->get();

        return view('insights.index', compact('insights', 'categories'));
    }

    public function category(string $slug): View
    {
        $category = InsightCategory::query()
            ->where('slug', $slug)
            ->firstOrFail();

        $insights = $category->insights()
            ->with(['category', 'user'])
            ->published()
            ->latest('published_at')
            ->latest('id')
            ->paginate(12);

        $categories = InsightCategory::query()->orderBy('name')->get();

        return view('insights.category', compact('category', 'insights', 'categories'));
    }

    public function show(Insight $insight): View
    {
        $insight = Insight::query()
            ->with(['category', 'user'])
            ->published()
            ->findOrFail($insight->getKey());

        return view('insights.show', compact('insight'));
    }
}
