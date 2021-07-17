<?php

namespace App\Http\Controllers;

use App\Http\Filters\ResourceFilters;
use App\Http\Requests\CreateArticleRequest;
use App\Models\Article;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ResourceFilters $filters, Article $article)
    {
        return $this->generateCachedResponse(function () use ($filters, $article) {
            $articleList = $article
                    ->filter($filters);

            return $this->paginateOrGet($articleList);
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateArticleRequest $request, Article $article)
    {
        try {
            DB::beginTransaction();
            $articleObject = $article->create($request->validated());

            // Set SLUG value
            $articleObject->slug = $articleObject->header;
            $articleObject->save();

            if ($request->tag_ids) {
                $articleObject->tags()->sync($request->tag_ids);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return \response(['message' => $th->getMessage()], 400);
        }

        return \response($articleObject, 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $article = $article->load([
            'category',
            'tags',
            'creator',
        ]);

        return response($article);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CreateArticleRequest $request, Article $article)
    {
        try {
            DB::beginTransaction();
            $article->update($request->validated());

            if ($request->tag_ids) {
                $article->tags()->sync($request->tag_ids);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return \response(['message' => $th->getMessage()], 400);
        }

        return response($article, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return response(['message' => 'Deleted successfully'], 200);
    }
}
