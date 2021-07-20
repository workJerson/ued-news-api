<?php

namespace App\Http\Controllers;

use App\Http\Filters\ResourceFilters;
use App\Http\Requests\CreateTagsRequest;
use App\Models\Tags;

class TagsController extends Controller
{
    /**
     * @OA\Get(
     *      path="/tags",
     *      operationId="indexTag",
     *      tags={"Tags"},
     *      summary="Get all Tags",
     *      description="Returns list of tag data",
     *        security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *          name="slug",
     *          description="Filter by the slug of tag",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="name",
     *          description="Filter by the name of tag",
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
    public function index(ResourceFilters $filters, Tags $tags)
    {
        return $this->generateCachedResponse(function () use ($filters, $tags) {
            $tagsList = $tags
                    ->filter($filters);

            return $this->paginateOrGet($tagsList);
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
     *      path="/tags",
     *      operationId="storeTags",
     *      tags={"Tags"},
     *      summary="Store new tag",
     *      description="Returns tag data",
     *        security={{"bearer_token":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreTagsRequestModel")
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
    public function store(CreateTagsRequest $request, Tags $tags)
    {
        $tagsObject = $tags->create($request->validated());

        // Set value of slug
        $tagsObject->slug = $tagsObject->name;
        $tagsObject->save();

        return \response($tagsObject, 201);
    }

    /**
     * @OA\Get(
     *      path="/tags/{id}",
     *      operationId="showTag",
     *      tags={"Tags"},
     *      summary="Show certain tag",
     *      description="Returns an tag data",
     *        security={{"bearer_token":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Tags id",
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
    public function show($id)
    {
        $tagObject = Tags::findOrFail($id);

        return response($tagObject);
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
     *      path="/tags/{id}",
     *      operationId="updateTags",
     *      tags={"Tags"},
     *      summary="Update existing tag",
     *      description="Returns updated tag data",
     *        security={{"bearer_token":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Tags id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateTagsRequestModel")
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
    public function update(CreateTagsRequest $request, $id)
    {
        $tags = Tags::findOrFail($id);
        $tags->update($request->validated());

        // Set value of slug
        $tags->slug = $tags->name;
        $tags->save();

        return \response($tags, 200);
    }

    /**
     * @OA\Delete(
     *      path="/tags/{id}",
     *      operationId="deleteTags",
     *      tags={"Tags"},
     *      summary="Delete existing Tags",
     *      description="Deletes a record and returns no content",
     *        security={{"bearer_token":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Tag id",
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
    public function destroy($id)
    {
        $tags = Tags::findOrFail($id);
        $tags->delete();

        return response(['message' => 'Deleted successfully'], 200);
    }
}
