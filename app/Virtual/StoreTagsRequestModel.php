<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Store Tag request",
 *      description="Store Tag request body data",
 *      type="object",
 *      required={"name"}
 * )
 */
class StoreTagsRequestModel
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="name of the new article",
     *      example="Sample Tag"
     * )
     */
    public string $name;
}
