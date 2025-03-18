<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }
        if (isset($filters['published_at'])) {
            $query->where('published_at', $filters['published_at']);
        }
        if (isset($filters['is_published'])) {
            $query->where('is_published', $filters['is_published']);
        }
    }

    public function getAvatarAttribute($value)
    {
        if ($value && file_exists(public_path('/images/news/' . $value))) {
            return url('/images/news/' . $value);
        } else {
            return url('/images/default/news-' . $this->gender . '.png');
        }
    }
}
