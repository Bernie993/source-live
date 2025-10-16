<?php

namespace App\View\Composers;

use App\Models\Post;
use Illuminate\View\View;

class PostComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Get latest published posts
        $latestPosts = Post::active()
            ->published()
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(4) // 1 main + 3 side posts
            ->get();

        // Split into main and side posts
        $mainPost = $latestPosts->first();
        $sidePosts = $latestPosts->slice(1, 3);

        $view->with([
            'mainPost' => $mainPost,
            'sidePosts' => $sidePosts,
        ]);
    }
}


