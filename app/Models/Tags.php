<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'name',
        'status',
    ];

    public function searchable()
    {
        return [
            'name',
            'news_header',
        ];
    }

    public function news()
    {
        return $this->belongsToMany(News::class);
    }
}
