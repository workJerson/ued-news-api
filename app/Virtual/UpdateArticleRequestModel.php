<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Update Article request",
 *      description="Update Article request body data",
 *      type="object",
 *      required={"name"}
 * )
 */
class UpdateArticleRequestModel extends StoreArticleRequestModel
{
    /**
     * @OA\Property(
     *      title="status",
     *      description="status of the new article 1 = Active, 0 = Inactive",
     *      example="1"
     * )
     *
     * @var string
     */
    public $status;
    /**
     * @OA\Property(
     *      title="view_count",
     *      description="view_count of the new article",
     *      example="100"
     * )
     *
     * @var string
     */
    public $view_count;
}
