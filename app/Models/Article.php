<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;
    use Filterable;
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'header',
        'body',
        'short_description',
        'video_path',
        'thumbnail_path',
        'view_count',
        'status',
        'created_by',
        'article_category_id',
    ];

    public function searchable()
    {
        return [
            'id',
            'status',
            'header',
            'category_name',
            'creator_first_name',
            'creator_last_name',
            'tags_name',
        ];
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function creatorDetails()
    {
        return $this->creator()->select(['first_name', 'last_name', 'middle_name', 'id']);
    }

    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'article_category_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class);
    }
}
