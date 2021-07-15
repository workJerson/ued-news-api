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
        return $this->hasMany(Article::class);
    }
}
