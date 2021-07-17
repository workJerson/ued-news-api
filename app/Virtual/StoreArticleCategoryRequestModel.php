<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Store Article Category request",
 *      description="Store Article Category request body data",
 *      type="object",
 *      required={"name"}
 * )
 */
class StoreArticleCategoryRequestModel
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="name of the new article category",
     *      example="Sample Category"
     * )
     */
    public string $name;
    /**
     * @OA\Property(
     *      title="description",
     *      description="description of the new article category",
     *      example="Sample description of article Category"
     * )
     */
    public string $description;
}
