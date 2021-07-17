<?php

namespace App\Http\Controllers;

use App\Http\Filters\ResourceFilters;
use App\Http\Requests\CreateArticleCategoryRequest;
use App\Models\ArticleCategory;

class ArticleCategoryController extends Controller
{
    /**
     * @OA\Get(
     *      path="/article-categories",
     *      operationId="indexArticleCategory",
     *      tags={"Article Categories"},
     *      summary="Get all article categories",
     *      description="Returns list of article categories data",
     *     @OA\Parameter(
     *          name="name",
     *          description="Filter by name of the article category",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="description",
     *          description="Filter by the description of articles category",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="status",
     *          description="Filter by status of article category 1 = Active, 0 = Inactive",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="page",
     *          description="Page number",
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
    public function index(ResourceFilters $filters, ArticleCategory $articleCategory)
    {
        return $this->generateCachedResponse(function () use ($filters, $articleCategory) {
            $articleCategoryList = $articleCategory
                    ->filter($filters);

            return $this->paginateOrGet($articleCategoryList);
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
     *      path="/article-categories",
     *      operationId="storeArticleCategory",
     *      tags={"Article Categories"},
     *      summary="Store new article category",
     *      description="Returns article category data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreArticleCategoryRequestModel")
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
    public function store(CreateArticleCategoryRequest $request, ArticleCategory $articleCategory)
    {
        $articleCategoryObject = $articleCategory->create($request->validated());

        return \response($articleCategoryObject, 201);
    }

    /**
     * @OA\Get(
     *      path="/article-categories/{articleCategory}",
     *      operationId="showArticleCategory",
     *      tags={"Article Categories"},
     *      summary="Show certain article category",
     *      description="Returns an article category data",
     *      @OA\Parameter(
     *          name="articleCategory",
     *          description="Article category's id",
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
    public function show(ArticleCategory $articleCategory)
    {
        return response($articleCategory);
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
     *      path="/article-categories/{articleCategory}",
     *      operationId="updateArticleCategory",
     *      tags={"Article Categories"},
     *      summary="Update existing article category",
     *      description="Returns updated article category data",
     *      @OA\Parameter(
     *          name="articleCategory",
     *          description="Article category id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateArticleCategoryRequestModel")
     *      ),
     *      @OA\Response(
     *          response=200,
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
    public function update(CreateArticleCategoryRequest $request, ArticleCategory $articleCategory)
    {
        $articleCategory->update($request->validated());

        return response($articleCategory);
    }

    /**
     * @OA\Delete(
     *      path="/article-categories/{articleCategory}",
     *      operationId="deleteArticleCategory",
     *      tags={"Article Categories"},
     *      summary="Delete existing Article Category",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="articleCategory",
     *          description="Article Category id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
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
    public function destroy(ArticleCategory $articleCategory)
    {
        $articleCategory->delete();

        return response(['message' => 'Deleted successfully'], 200);
    }
}
