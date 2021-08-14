<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Tags;

class DashboardController extends Controller
{
    public function __invoke(Article $article, ArticleCategory $articleCategory, Tags $tags)
    {
        $data = [];
        $data['total_article_count'] = $article->count();
        $data['total_category_count'] = $articleCategory->count();
        $data['total_tags_count'] = $tags->count();
        $data['total_article_count_per_category'] = $articleCategory->select('id', 'name')->withCount(['articles'])->get();

        return response($data, 200);
    }
}
