<?php

namespace App\Http\Controllers;

use App\Http\Filters\ResourceFilters;
use App\Models\Article;
use App\Models\ArticleCategory;

class PublicController extends Controller
{
    public function __invoke()
    {
        $data = [];

        $data['latest_news'] = Article::whereHas('category', function ($query) { // Get latest news take 4
            $query->where('name', 'News');
        })->orderBy('id', 'desc')
            ->take(4)
            ->get();

        $data['most_read'] = Article::whereHas('category', function ($query) { // Get latest news with highest views
            $query->where('name', 'News');
        })->orderBy('view_count', 'desc')
            ->take(4)
            ->get();

        $data['watch_now'] = Article::whereNotNull('video_path') // Get latest articles with video
                    ->orderBy('id', 'desc')
                    ->take(5)
                    ->with(['category'])
                    ->get();

        // List of categories that will be shown on home page. For discussion (CMS)
        $categories = [
            'News',
            'Business',
            'Entertainment',
            'Health',
        ];
        $data['categories'] = ArticleCategory::whereIn('name', $categories)
                    ->with([
                        'latestArticles',
                    ])->get();

        return response($data, 200);
    }

    public function showArticleBySlug(string $slug)
    {
        $data = [];
        $article = Article::where('slug', $slug)->first();

        if ($article != null) {
            // Increment view count
            $article->increment('view_count');
            $article->load([
                'category',
                'tags',
            ]);

            $data['article'] = $article;
            $data['related_news'] = Article::where('article_category_id', $article->article_category_id)
                        ->orderBy('id', 'desc')
                        ->orderBy('view_count', 'desc')
                        ->take(10)->get();
            $data['latest_videos'] = Article::whereNotNull('video_path')
                        ->orderBy('id', 'desc')
                        ->orderBy('view_count', 'desc')
                        ->take(4)
                        ->with(['category'])
                        ->get();

            return response($data, 200);
        }

        return response(['message' => 'Invalid Article'], 404);
    }

    public function showArticlesByTag(string $slug, ResourceFilters $filters, Article $articles)
    {
        return $this->generateCachedResponse(function () use ($filters, $articles, $slug) {
            $articleList = $articles
                    ->whereHas('tags', function ($query) use ($slug) {
                        $query->where('slug', $slug);
                    })
                    ->with(['tags', 'category'])
                    ->filter($filters)
                    ->where('status', '!=', 2);

            return $this->paginateOrGet($articleList);
        });
    }
}
