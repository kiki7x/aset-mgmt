<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KnowledgeBaseController extends Controller
{
    public function index(Request $request)
    {
        $categories = \App\Models\KbCategoriesModel::all();
        $articles = \App\Models\KbArticlesModel::with('category', 'author')->latest()->get();

        return view('admin.knowledge-base.index', compact('articles', 'categories'));
    }

    // --- Artikel Management ---

    public function create()
    {
        $categories = \App\Models\KbCategoriesModel::all();
        return view('admin.knowledge-base.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:kb_articles,title',
            'category_id' => 'required|exists:kb_categories,id',
            'content' => 'required',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $supportsFeaturedImageColumn = $this->supportsFeaturedImageColumn();
        $featuredImagePath = null;
        $content = $request->input('content');

        if ($request->hasFile('featured_image')) {
            $featuredImagePath = $request->file('featured_image')->store('kb_featured_images', 'public');
        }

        $content = $this->normalizeFeaturedImageContent($content, $featuredImagePath, $supportsFeaturedImageColumn);

        $payload = [
            'title' => $request->title,
            'category_id' => $request->category_id,
            'content' => $content,
            'author_id' => Auth::id(),
            'slug' => Str::slug($request->title), // Sudah di boot model, tapi bisa dipertegas
        ];

        if ($supportsFeaturedImageColumn) {
            $payload['featured_image'] = $featuredImagePath;
        }

        \App\Models\KbArticlesModel::create($payload);

        return redirect()->route('admin.knowledge-base');
    }

    public function edit(\App\Models\KbArticlesModel $article)
    {
        $categories = \App\Models\KbCategoriesModel::all();
        return view('admin.knowledge-base.edit', compact('article', 'categories'));
    }

    public function update(Request $request, \App\Models\KbArticlesModel $article)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:kb_articles,title,' . $article->id,
            'category_id' => 'required|exists:kb_categories,id',
            'content' => 'required',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $supportsFeaturedImageColumn = $this->supportsFeaturedImageColumn();
        $content = $request->input('content');
        $featuredImagePath = $supportsFeaturedImageColumn
            ? $article->featured_image
            : $this->extractFeaturedImagePathFromContent($article->content);

        if ($request->hasFile('featured_image')) {
            if ($featuredImagePath) {
                Storage::disk('public')->delete($featuredImagePath);
            }

            $featuredImagePath = $request->file('featured_image')->store('kb_featured_images', 'public');
        }

        $content = $this->normalizeFeaturedImageContent($content, $featuredImagePath, $supportsFeaturedImageColumn);

        $payload = [
            'title' => $request->title,
            'category_id' => $request->category_id,
            'content' => $content,
            'slug' => Str::slug($request->title), // Sudah di boot model, tapi bisa dipertegas
        ];

        if ($supportsFeaturedImageColumn) {
            $payload['featured_image'] = $featuredImagePath;
        }

        $article->update($payload);

        return redirect()->route('admin.knowledge-base');
    }

    public function destroy(\App\Models\KbArticlesModel $article)
    {
        $supportsFeaturedImageColumn = $this->supportsFeaturedImageColumn();
        $featuredImagePath = $supportsFeaturedImageColumn
            ? $article->featured_image
            : $this->extractFeaturedImagePathFromContent($article->content);

        if ($featuredImagePath) {
            Storage::disk('public')->delete($featuredImagePath);
        }

        $article->delete();
        return redirect()->route('admin.knowledge-base');
    }

    private function supportsFeaturedImageColumn(): bool
    {
        try {
            return Schema::hasColumn('kb_articles', 'featured_image');
        } catch (\Throwable $e) {
            return false;
        }
    }

    private function injectFeaturedImageIntoContent(?string $content, string $imagePath): string
    {
        $content = $this->stripFeaturedImageMarker($content ?? '');
        $imageUrl = asset('storage/' . $imagePath);
        $marker = '<div class="kb-featured-image" data-kb-featured="1" data-kb-featured-path="' . e($imagePath) . '"><img src="' . e($imageUrl) . '" alt="Featured Image" style="max-width:100%;height:auto;"></div>';

        return $marker . "\n" . $content;
    }

    private function normalizeFeaturedImageContent(?string $content, ?string $featuredImagePath, bool $supportsFeaturedImageColumn): string
    {
        $content = $this->stripFeaturedImageMarker($content ?? '');

        if (!$supportsFeaturedImageColumn && $featuredImagePath) {
            return $this->injectFeaturedImageIntoContent($content, $featuredImagePath);
        }

        return $content;
    }

    private function stripFeaturedImageMarker(string $content): string
    {
        return preg_replace('/<div[^>]*data-kb-featured="1"[^>]*>.*?<\/div>\s*/is', '', $content) ?? $content;
    }

    private function extractFeaturedImagePathFromContent(?string $content): ?string
    {
        if (empty($content)) {
            return null;
        }

        if (preg_match('/data-kb-featured-path="([^"]+)"/i', $content, $matches)) {
            return html_entity_decode($matches[1], ENT_QUOTES, 'UTF-8');
        }

        return null;
    }

    // --- Category Management (via AJAX atau modal) ---

    public function categoryStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:kb_categories,name',
            'description' => 'nullable|string',
        ]);

        $category = \App\Models\KbCategoriesModel::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return response()->json(['success' => true, 'message' => 'Kategori berhasil ditambahkan!', 'category' => $category]);
    }

    public function categoryUpdate(Request $request, \App\Models\KbCategoriesModel $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:kb_categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return response()->json(['success' => true, 'message' => 'Kategori berhasil diperbarui!', 'category' => $category]);
    }

    public function categoryDestroy(\App\Models\KbCategoriesModel $category)
    {
        if ($category->articles()->count() > 0) {
            return response()->json(['success' => false, 'message' => 'Tidak bisa menghapus kategori yang memiliki artikel!'], 400);
        }

        $category->delete();
        return response()->json(['success' => true, 'message' => 'Kategori berhasil dihapus!']);
    }

    // --- Summernote Image Upload ---
    // --- Frontsite (public) views ---

    public function publicIndex()
    {
        $categories = \App\Models\KbCategoriesModel::all();
        $articles = \App\Models\KbArticlesModel::with('category', 'author')->where('is_published', 1)->latest()->get();

        return view('frontsite.knowledge-base.index', compact('articles', 'categories'));
    }

    public function show($slug)
    {
        $article = \App\Models\KbArticlesModel::with('category', 'author')->where('slug', $slug)->where('is_published', 1)->firstOrFail();

        // Increment views counter (best-effort)
        try {
            $article->increment('views');
        } catch (\Exception $e) {
            // ignore increment errors
        }

        $related = \App\Models\KbArticlesModel::with('category')->where('category_id', $article->category_id)->where('id', '!=', $article->id)->where('is_published', 1)->take(5)->get();

        return view('frontsite.knowledge-base.show', compact('article', 'related'));
    }

    public function uploadImage(Request $request)
    {
        // Terima gambar atau video. Ukuran maksimum diset lebih besar (KB): images up to 5MB, videos up to 50MB.
        $request->validate([
            'image' => 'required|file|mimes:jpeg,png,jpg,gif,svg,mp4,mov,avi,mkv|max:51200', // max 50MB
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $mime = $file->getMimeType();

            // Tentukan folder berdasarkan tipe
            $isImage = str_starts_with($mime, 'image/');
            $folder = $isImage ? 'kb_images' : 'kb_videos';

            $fileName = time() . '_' . Str::random(10) . '.' . $ext;
            $file->move(public_path('storage/' . $folder), $fileName);

            // Pastikan `php artisan storage:link` sudah dijalankan
            $url = asset('storage/' . $folder . '/' . $fileName);

            if ($isImage) {
                return response()->json([
                    'url' => $url,
                    'type' => 'image',
                ]);
            }

            $iframe = '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="' . e($url) . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';

            return response()->json([
                'url' => $url,
                'type' => 'video',
                'iframe' => $iframe,
            ]);
        }

        return response()->json(['error' => 'Gagal mengunggah file'], 400);
    }
}
