<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tags extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'slug',
        'name',
        'status',
    ];

    public function searchable()
    {
        return [
            'name',
            'articles_header',
        ];
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
