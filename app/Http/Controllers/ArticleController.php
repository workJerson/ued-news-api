<?php

namespace App\Http\Controllers;

use App\Http\Filters\ResourceFilters;
use App\Http\Requests\CreateArticleRequest;
use App\Models\Article;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * @OA\Get(
     *      path="/articles",
     *      operationId="indexArticle",
     *      tags={"Articles"},
     *      summary="Get all articles",
     *      description="Returns list of article data",
     *     @OA\Parameter(
     *          name="header",
     *          description="Filter by header of the article",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="category_name",
     *          description="Filter by the name of article's category",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="creator_full_name",
     *          description="Filter by the full name of article's creator",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="tags_name",
     *          description="Filter by the name of article's tags",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="status",
     *          description="Filter by status of article 1 = Active, 0 = Inactive",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="page",
     *          description="Page",
     *          required=true,
     *          in="query",
     *          example="1",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="per_page",
     *          description="Items per page",
     *          required=false,
     *          in="query",
     *          example="15",
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
     * @OA\Post(
     *      path="/articles",
     *      operationId="storeArticle",
     *      tags={"Articles"},
     *      summary="Store new article",
     *      description="Returns article data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreArticleRequestModel")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
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
     * @OA\Get(
     *      path="/articles/{article}",
     *      operationId="showArticle",
     *      tags={"Articles"},
     *      summary="Show certain article",
     *      description="Returns an article data",
     *      @OA\Parameter(
     *          name="article",
     *          description="Article's id",
     *          required=true,
     *          in="path",
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
     * @OA\Put(
     *      path="/articles/{article}",
     *      operationId="updateArticle",
     *      tags={"Articles"},
     *      summary="Update existing article",
     *      description="Returns updated article data",
     *      @OA\Parameter(
     *          name="article",
     *          description="Article id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateArticleRequestModel")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
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
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

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
     * @OA\Delete(
     *      path="/articles/{article}",
     *      operationId="deleteArticle",
     *      tags={"Articles"},
     *      summary="Delete existing Article",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="article",
     *          description="Article id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

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
