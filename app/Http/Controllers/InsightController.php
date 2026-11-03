<?php

namespace App\Http\Controllers;

use App\Models\Insight;
use App\Models\InsightCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class InsightController extends Controller
{
    public function index(): View
    {
        if (intl_locale() !== 'ko') {
            $insights = Insight::query()->published()
                ->whereHas('translations', fn ($query) => $query->where('locale', intl_locale()))
                ->with(['category', 'user', 'translation'])->latest('published_at')->latest('id')
                ->paginate(12)->withPath(intl_route('insights.index'));
            $categories = $this->translatedCategories();

            return intl_view('insights.index', compact('insights', 'categories'));
        }

        $insights = Insight::query()
            ->with(['category', 'user'])
            ->published()
            ->latest('published_at')
            ->latest('id')
            ->paginate(12)
            ->withPath(route('insights.index'));

        $categories = InsightCategory::query()->orderBy('name')->get();

        return view('insights.index', compact('insights', 'categories'));
    }

    public function category(string $slug): View
    {
        if (intl_locale() !== 'ko') {
            $categories = $this->translatedCategories();
            $category = $categories->firstWhere('slug', $slug);
            abort_unless($category, 404);
            $insights = $category->insights()->published()
                ->whereHas('translations', fn ($query) => $query->where('locale', intl_locale()))
                ->with(['category', 'user', 'translation'])->latest('published_at')->latest('id')
                ->paginate(12)->withPath(intl_route('insights.category', ['slug' => $slug]));

            return intl_view('insights.category', compact('category', 'insights', 'categories'));
        }

        $category = InsightCategory::query()
            ->where('slug', $slug)
            ->firstOrFail();

        $insights = $category->insights()
            ->with(['category', 'user'])
            ->published()
            ->latest('published_at')
            ->latest('id')
            ->paginate(12)
            ->withPath(route('insights.category', ['slug' => $slug]));

        $categories = InsightCategory::query()->orderBy('name')->get();

        return view('insights.category', compact('category', 'insights', 'categories'));
    }

    public function show(Insight $insight): View|RedirectResponse
    {
        if ($insight->isHidden()) {
            return redirect()->route('insights.index', [], 302);
        }

        $insight = Insight::query()
            ->with(['category', 'user'])
            ->published()
            ->findOrFail($insight->getKey());

        return view('insights.show', compact('insight'));
    }

    public function translatedShow(string $slug): View
    {
        $insight = Insight::query()->published()
            ->whereHas('translations', fn ($query) => $query->where('locale', intl_locale())->where('slug', $slug))
            ->with(['category', 'user', 'translation'])->firstOrFail();
        $translation = $insight->translation;
        request()->attributes->set('intl.insight', $insight);

        return intl_view('insights.show', compact('insight', 'translation'));
    }

    private function translatedCategories(): Collection
    {
        return InsightCategory::query()
            ->whereHas('insights', fn ($query) => $query->published()
                ->whereHas('translations', fn ($query) => $query->where('locale', intl_locale())))
            ->orderBy('name')->get();
    }
}
