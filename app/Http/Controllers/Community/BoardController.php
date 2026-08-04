<?php

namespace App\Http\Controllers\Community;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Illuminate\View\View;

class BoardController extends Controller
{
    public function index(): View
    {
        $boards = Board::query()
            ->orderBy('order')
            ->get();

        return view('community.index', compact('boards'));
    }

    public function show(Board $board): View
    {
        $notices = $board->posts()
            ->with('user')
            ->published()
            ->where('is_notice', true)
            ->latest('published_at')
            ->latest('id')
            ->get();

        $posts = $board->posts()
            ->with('user')
            ->published()
            ->where('is_notice', false)
            ->latest('published_at')
            ->latest('id')
            ->paginate(20);

        return view('community.board', compact('board', 'notices', 'posts'));
    }
}
