<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
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

    public function news()
    {
        return $this->hasMany(News::class);
    }
}
