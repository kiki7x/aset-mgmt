<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KbArticlesModel extends Model
{
    use HasFactory;

    protected $table = 'kb_articles';

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'content',
        'author_id',
        'is_published',
        'views',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($article) {
            $article->slug = Str::slug($article->title);
            $article->author_id = auth()->id(); // Otomatis mengisi author_id
        });

        static::updating(function ($article) {
            $article->slug = Str::slug($article->title);
        });
    }

    public function category()
    {
        return $this->belongsTo(KbCategoriesModel::class, 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}