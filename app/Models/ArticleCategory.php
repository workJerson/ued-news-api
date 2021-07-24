<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ArticleCategory extends Model
{
    use HasFactory;
    use Filterable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'status',
    ];

    public function searchable()
    {
        return [
            'name',
            'description',
            'status',
        ];
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'article_category_id', 'id');
    }

    public function latestArticles()
    {
        return $this->articles()
            ->orderBy('id', 'desc')
            ->orderBy('view_count', 'desc')
            ->take(5);
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }
}
