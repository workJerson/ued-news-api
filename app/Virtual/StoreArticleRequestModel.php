<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Store Article request",
 *      description="Store Article request body data",
 *      type="object",
 *      required={"name"}
 * )
 */
class StoreArticleRequestModel
{
    /**
     * @OA\Property(
     *      title="header",
     *      description="header of the new article",
     *      example="A nice article"
     * )
     *
     * @var string
     */
    public $header;
    /**
     * @OA\Property(
     *      title="body",
     *      description="body of the new article",
     *      example="<p>Content here</p>"
     * )
     *
     * @var string
     */
    public $body;
    /**
     * @OA\Property(
     *      title="video_path",
     *      description="body of the new article",
     *      example="https://www.youtube.com/watch?v=dQw4w9WgXcQ"
     * )
     *
     * @var string
     */
    public $video_path;
    /**
     * @OA\Property(
     *      title="thumbnail_path",
     *      description="body of the new article",
     *      example="https://i.ytimg.com/an_webp/dQw4w9WgXcQ/mqdefault_6s.webp?du=3000&sqp=CLisy4cG&rs=AOn4CLDj6lo3qNP4APhTvCFcJLlAEKlYkw"
     * )
     *
     * @var string
     */
    public $thumbnail_path;
    /**
     * @OA\Property(
     *      title="article_category_id",
     *      type="integer",
     *      description="body of the new article",
     *      example="1"
     * )
     *
     * @var string
     */
    public $article_category_id;
    /**
     * @OA\Property(
     *      title="tag_ids",
     *      type="array",
     *      description="body of the new article",
     *      @OA\Items(
     *          type="integer",
     *          example="1"
     *      )
     * )
     *
     * @var string
     */
    public $tag_ids;
}
