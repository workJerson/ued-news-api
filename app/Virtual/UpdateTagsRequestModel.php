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
     *      description="status of the tag  1 = Active, 0 = Inactive",
     *      example="1"
     * )
     */
    public string $status;
}
