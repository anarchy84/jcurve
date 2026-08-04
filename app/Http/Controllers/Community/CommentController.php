<?php

namespace App\Http\Controllers\Community;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    public function store(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:5000'],
            'parent_id' => ['nullable', 'integer'],
        ]);

        DB::transaction(function () use ($post, $request, $validated): void {
            $lockedPost = Post::query()
                ->published()
                ->lockForUpdate()
                ->findOrFail($post->getKey());

            $parent = null;

            if (isset($validated['parent_id'])) {
                $parent = Comment::query()
                    ->whereKey($validated['parent_id'])
                    ->where('post_id', $lockedPost->getKey())
                    ->lockForUpdate()
                    ->first();

                if ($parent === null || $parent->parent_id !== null) {
                    throw ValidationException::withMessages([
                        'parent_id' => '답글은 같은 게시글의 최상위 댓글에만 작성할 수 있습니다.',
                    ]);
                }
            }

            $comment = new Comment;
            $comment->post()->associate($lockedPost);
            $comment->user()->associate($request->user());
            $comment->parent()->associate($parent);
            $comment->content = $validated['content'];
            $comment->save();

            $lockedPost->comment_count++;
            $lockedPost->save();
        });

        return back()->with('status', 'comment-created');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        Gate::authorize('delete', $comment);

        DB::transaction(function () use ($comment): void {
            $post = Post::query()
                ->lockForUpdate()
                ->findOrFail($comment->post_id);

            $lockedComment = Comment::query()
                ->whereKey($comment->getKey())
                ->where('post_id', $post->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            $children = $lockedComment->children()
                ->lockForUpdate()
                ->get();

            foreach ($children as $child) {
                $child->delete();
            }

            $lockedComment->delete();

            $deletedCount = 1 + $children->count();
            $post->comment_count = max(0, $post->comment_count - $deletedCount);
            $post->save();
        });

        return back()->with('status', 'comment-deleted');
    }
}
