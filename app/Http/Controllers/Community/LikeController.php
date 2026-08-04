<?php

namespace App\Http\Controllers\Community;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{
    public function toggle(Request $request, Post $post): JsonResponse
    {
        $result = DB::transaction(function () use ($request, $post): array {
            $lockedPost = Post::query()
                ->published()
                ->lockForUpdate()
                ->findOrFail($post->getKey());

            $like = PostLike::query()
                ->where('post_id', $lockedPost->getKey())
                ->where('user_id', $request->user()->getKey())
                ->first();

            if ($like !== null) {
                $like->delete();
                $lockedPost->like_count = max(0, $lockedPost->like_count - 1);
                $liked = false;
            } else {
                $like = new PostLike;
                $like->post()->associate($lockedPost);
                $like->user()->associate($request->user());
                $like->save();

                $lockedPost->like_count++;
                $liked = true;
            }

            $lockedPost->save();

            return [
                'liked' => $liked,
                'like_count' => $lockedPost->like_count,
            ];
        });

        return response()->json($result);
    }
}
