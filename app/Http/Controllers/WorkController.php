<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\View\View;

class WorkController extends Controller
{
    public function index(): View
    {
        $works = Work::query()
            ->published()
            ->latest('published_at')
            ->latest('id')
            ->paginate(12);

        return view('work.index', compact('works'));
    }

    public function show(Work $work): View
    {
        $work = Work::query()
            ->published()
            ->findOrFail($work->getKey());

        return view('work.show', compact('work'));
    }
}
