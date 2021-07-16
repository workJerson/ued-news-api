<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public function searchable()
    {
        return [
            'name',
            'description',
        ];
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'article_category_id', 'id');
    }

    public function latestArticles()
    {
        return $this->articles()
            ->orderBy('view_count', 'desc')
            ->orderBy('id', 'desc')
            ->take(2);
    }
}
