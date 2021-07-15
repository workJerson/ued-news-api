<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'header',
        'body',
        'view_path',
        'thumbnail_path',
        'view_count',
        'status',
        'created_by',
        'article_category_id',
    ];

    public function searchable()
    {
        return [
            'header',
            'category_name',
            'creator_full_name',
        ];
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(ArticleCategory::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class);
    }
}
