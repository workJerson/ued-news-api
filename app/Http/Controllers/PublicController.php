<?php

namespace App\Http\Controllers;

use App\Http\Filters\ResourceFilters;
use App\Models\Article;
use App\Models\ArticleCategory;

class PublicController extends Controller
{
    /**
     * @OA\Get(
     *      path="/public/articles",
     *      operationId="__invoke",
     *      tags={"Public"},
     *      summary="Get list of articles for home page",
     *      description="Returns list of articles",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function __invoke()
    {
        $data = [];

        $data['latest_news'] = Article::whereHas('category', function ($query) { // Get latest news take 4
            $query->where('name', 'News');
        })->orderBy('id', 'desc')
            ->take(5)
            ->get();

        $data['most_read'] = Article::whereHas('category', function ($query) { // Get latest news with highest views
            $query->where('name', 'News');
        })->orderBy('view_count', 'desc')
            ->take(5)
            ->get();

        $data['top_stories'] = Article::orderBy('id', 'desc') // Get first two top articles
            ->take(3)
            ->with(['category'])
            ->get();

        $data['watch_now'] = Article::whereNotNull('video_path') // Get latest articles with video
                    ->orderBy('id', 'desc')
                    ->take(4)
                    ->with(['category'])
                    ->get();

        // List of categories that will be shown on home page. For discussion (CMS)
        $categories = [
            'News',
            'Business',
            'Entertainment',
            'Video',
        ];

        $categoryList = ArticleCategory::whereIn('name', $categories)->get();
        // WIP: For refactor to remove loop query
        $categoryList->each(function ($item, $key) {
            $item->latest_articles = Article::where('article_category_id', $item->id)
            ->orderBy('id', 'desc')
                ->orderBy('view_count', 'desc')
                ->take(5)
                ->get();
        });

        $data['categories'] = $categoryList;

        $data['latest_videos'] = Article::whereNotNull('video_path') // Get latest articles with video
                    ->orderBy('id', 'desc')
                    ->take(4)
                    ->with(['category'])
                    ->get();

        return response($data, 200);
    }

    /**
     * @OA\Get(
     *      path="/public/articles/{slug}",
     *      operationId="showArticleBySlug",
     *      tags={"Public"},
     *      summary="Get article information by slug",
     *      description="Returns article data",
     *      @OA\Parameter(
     *          name="slug",
     *          description="Article's slug",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
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

    /**
     * @OA\Get(
     *      path="/public/articles/tags/{slug}",
     *      operationId="showArticlesByTag",
     *      tags={"Public"},
     *      summary="Get all articles by Tag's slug",
     *      description="Returns list of article data",
     *      @OA\Parameter(
     *          name="slug",
     *          description="Tags slug",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="page",
     *          description="Page",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="per_page",
     *          description="Items per page",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function showArticlesByTag(string $slug, ResourceFilters $filters, Article $articles)
    {
        return $this->generateCachedResponse(function () use ($filters, $articles, $slug) {
            $articleList = $articles
                    ->whereHas('tags', function ($query) use ($slug) {
                        $query->where('slug', $slug);
                    })
                    ->with(['tags', 'category'])
                    ->filter($filters);

            return $this->paginateOrGet($articleList);
        });
    }

    /**
     * @OA\Get(
     *      path="/public/articles/category/{slug}",
     *      operationId="showArticlesByCategory",
     *      tags={"Public"},
     *      summary="Get all articles by category name",
     *      description="Returns list of article data",
     *      @OA\Parameter(
     *          name="categoryName",
     *          description="Category name",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="page",
     *          description="Page",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="per_page",
     *          description="Items per page",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function showArticlesByCategory(string $slug, ResourceFilters $filters, Article $articles)
    {
        return $this->generateCachedResponse(function () use ($filters, $articles, $slug) {
            $articleList = $articles
                    ->whereHas('category', function ($query) use ($slug) {
                        $query->where('slug', $slug);
                    })
                    ->with(['tags'])
                    ->filter($filters);

            return $this->paginateOrGet($articleList);
        });
    }

    /**
     * @OA\Get(
     *      path="/public/categories",
     *      operationId="showAllCategories",
     *      tags={"Public"},
     *      summary="Get all article categories",
     *      description="Returns list of article category data",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function showAllCategories()
    {
        return ArticleCategory::all();
    }
}
