<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
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
        'featured_image',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($article) {
            $article->slug = Str::slug($article->title);
            $article->author_id = Auth::id(); // Otomatis mengisi author_id
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

    public function getRenderedContentAttribute(): string
    {
        $content = $this->content ?? '';

        // Remove internal featured marker from visible article body.
        $content = preg_replace('/<div[^>]*data-kb-featured="1"[^>]*>.*?<\/div>\s*/is', '', $content) ?? $content;

        if (str_contains($content, '<iframe')) {
            return $content;
        }

        $patterns = [
            '#(?:https?:)?//(?:www\.)?(?:youtube\.com/watch\?v=|youtube\.com/embed/|youtu\.be/|youtube-nocookie\.com/embed/)([\w-]{11})(?:[?&][^\s<>"]*)?#i' => function (array $matches): string {
                $videoId = $matches[1];
                return '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/' . e($videoId) . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';
            },
            '#(?:https?:)?//(?:www\.)?vimeo\.com/(?:video/)?(\d+)(?:[?&][^\s<>"]*)?#i' => function (array $matches): string {
                $videoId = $matches[1];
                return '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://player.vimeo.com/video/' . e($videoId) . '" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div>';
            },
            '#(?:https?:)?//(?:www\.)?(?:dailymotion\.com/video/|dai\.ly/)([\w-]+)(?:[?&][^\s<>"]*)?#i' => function (array $matches): string {
                $videoId = $matches[1];
                return '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://www.dailymotion.com/embed/video/' . e($videoId) . '" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div>';
            },
        ];

        foreach ($patterns as $pattern => $replacer) {
            $content = preg_replace_callback($pattern, $replacer, $content);
        }

        return $content;
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        if (!empty($this->featured_image)) {
            return asset('storage/' . $this->featured_image);
        }

        $content = $this->content ?? '';

        if (preg_match('/data-kb-featured-path="([^"]+)"/i', $content, $matches)) {
            return asset('storage/' . html_entity_decode($matches[1], ENT_QUOTES, 'UTF-8'));
        }

        if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $content, $matches)) {
            return $matches[1];
        }

        return null;
    }
}