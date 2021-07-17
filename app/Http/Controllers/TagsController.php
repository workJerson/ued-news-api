<?php

namespace App\Http\Controllers;

use App\Http\Filters\ResourceFilters;
use App\Http\Requests\CreateTagsRequest;
use App\Models\Tags;

class TagsController extends Controller
{
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
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tags $tags)
    {
        $tags->delete();

        return response(['message' => 'Deleted successfully'], 200);
    }
}
