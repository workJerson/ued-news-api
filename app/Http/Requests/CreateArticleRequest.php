<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'header' => [
                'required',
                'string',
            ],
            'body' => [
                'required',
                'string',
            ],
            'video_path' => [
                'nullable',
                'string',
            ],
            'thumbnail_path' => [
                'nullable',
                'string',
            ],
            'view_count' => [
                'nullable',
                'numeric',
            ],
            'article_category_id' => [
                'required',
                'numeric',
                'exists:article_categories,id',
            ],
            'tag_ids' => [
                'nullable',
                'array',
            ],
            'tags_ids.*' => [
                'nullable',
                'numeric',
                'exists:tags,id',
            ],
        ];
    }
}
