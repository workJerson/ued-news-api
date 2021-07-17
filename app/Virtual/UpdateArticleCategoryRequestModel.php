<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Update Article Category request",
 *      description="Update Article Category request body data",
 *      type="object",
 *      required={"name"}
 * )
 */
class UpdateArticleCategoryRequestModel extends StoreArticleCategoryRequestModel
{
    /**
     * @OA\Property(
     *      title="status",
     *      description="status of the article category 1 = Active, 0 = Inactive",
     *      example="1"
     * )
     */
    public int $status;
}
