<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Update Tag request",
 *      description="Update Tag request body data",
 *      type="object",
 *      required={"name"}
 * )
 */
class UpdateTagsRequestModel extends StoreTagsRequestModel
{
    /**
     * @OA\Property(
     *      title="status",
     *      description="name of the new article",
     *      example="1"
     * )
     */
    public string $status;
}
