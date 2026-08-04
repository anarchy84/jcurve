<?php

namespace App\Http\Controllers\Community;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function show(Request $request, Board $board, string $postSlug): View|RedirectResponse
    {
        if (! preg_match('/^(?<id>[1-9][0-9]*)-(?<slug>.+)$/u', $postSlug, $matches)) {
            abort(404);
        }

        $post = Post::query()
            ->with(['board', 'user'])
            ->published()
            ->where('board_id', $board->getKey())
            ->findOrFail((int) $matches['id']);

        $canonicalSlug = $this->routeSlug($post);

        if ($postSlug !== $canonicalSlug) {
            return redirect()->route('community.post', [
                'board' => $board,
                'postSlug' => $canonicalSlug,
            ], 301);
        }

        $viewedSessionKey = "viewed.{$post->getKey()}";

        if (! $request->session()->has($viewedSessionKey)) {
            $post->increment('view_count');
            $request->session()->put($viewedSessionKey, true);
        }

        $comments = $post->comments()
            ->whereNull('parent_id')
            ->with(['user', 'children.user'])
            ->oldest('created_at')
            ->oldest('id')
            ->get();

        $post->setRelation('comments', $comments);

        return view('community.show', compact('board', 'post', 'comments'));
    }

    public function create(Request $request, Board $board): View
    {
        $this->authorizeBoardWrite($board, $request->user());

        return view('community.create', compact('board'));
    }

    public function store(Request $request, Board $board): RedirectResponse
    {
        $user = $request->user();
        $this->authorizeBoardWrite($board, $user);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $post = new Post;
        $post->board()->associate($board);
        $post->user()->associate($user);
        $post->title = $validated['title'];
        $post->slug = $this->slugFromTitle($validated['title']);
        $post->content = $validated['content'];
        $post->published_at = now();
        $post->save();

        return redirect()->route('community.post', [
            'board' => $board,
            'postSlug' => $this->routeSlug($post),
        ]);
    }

    public function edit(Board $board, Post $post): View
    {
        $this->ensurePostBelongsToBoard($post, $board);
        Gate::authorize('update', $post);

        return view('community.edit', compact('board', 'post'));
    }

    public function update(Request $request, Board $board, Post $post): RedirectResponse
    {
        $this->ensurePostBelongsToBoard($post, $board);
        Gate::authorize('update', $post);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $post->title = $validated['title'];
        $post->slug = $this->slugFromTitle($validated['title']);
        $post->content = $validated['content'];
        $post->save();

        return redirect()->route('community.post', [
            'board' => $board,
            'postSlug' => $this->routeSlug($post),
        ]);
    }

    public function destroy(Board $board, Post $post): RedirectResponse
    {
        $this->ensurePostBelongsToBoard($post, $board);
        Gate::authorize('delete', $post);

        $post->delete();

        return redirect()->route('community.board', $board);
    }

    private function authorizeBoardWrite(Board $board, ?User $user): void
    {
        if ($user === null) {
            abort(403);
        }

        $isAllowed = match ($board->write_permission) {
            'guest', 'member' => true,
            'admin' => $user->role === 'admin',
            default => false,
        };

        abort_unless($isAllowed, 403);
    }

    private function ensurePostBelongsToBoard(Post $post, Board $board): void
    {
        abort_unless((int) $post->board_id === (int) $board->getKey(), 404);
    }

    private function slugFromTitle(string $title): string
    {
        $slug = preg_replace('/[^\p{L}\p{N}]+/u', '-', Str::lower(trim($title))) ?? '';
        $slug = trim($slug, '-');

        return Str::limit($slug !== '' ? $slug : 'post', 255, '');
    }

    private function routeSlug(Post $post): string
    {
        return "{$post->getKey()}-{$post->slug}";
    }
}
