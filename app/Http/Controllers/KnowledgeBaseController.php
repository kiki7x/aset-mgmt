<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KbArticleModel; // Pastikan menggunakan model yang benar
use App\Models\KbCategoryModel; // Pastikan menggunakan model yang benar
use Illuminate\Support\Str;

class KnowledgeBaseController extends Controller
{
    public function index(Request $request)
    {
        $categories = KbCategoryModel::all();
        $articles = KbArticleModel::with('category', 'author')->latest()->get();

        return view('admin.knowledge-base.index', compact('articles', 'categories'));
    }

    // --- Artikel Management ---

    public function create()
    {
        $categories = KbCategoryModel::all();
        return view('admin.knowledge-base.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:kb_articles,title',
            'category_id' => 'required|exists:kb_categories,id',
            'content' => 'required',
        ]);

        KbArticleModel::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'content' => $request->content,
            'author_id' => auth()->id(),
            'slug' => Str::slug($request->title), // Sudah di boot model, tapi bisa dipertegas
        ]);

        return redirect()->route('admin.knowledge-base');
    }

    public function edit(KbArticleModel $article)
    {
        $categories = KbCategoryModel::all();
        return view('admin.knowledge-base.edit', compact('article', 'categories'));
    }

    public function update(Request $request, KbArticleModel $article)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:kb_articles,title,' . $article->id,
            'category_id' => 'required|exists:kb_categories,id',
            'content' => 'required',
        ]);

        $article->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'content' => $request->content,
            'slug' => Str::slug($request->title), // Sudah di boot model, tapi bisa dipertegas
        ]);

        return redirect()->route('admin.knowledge-base.index');
    }

    public function destroy(KbArticleModel $article)
    {
        $article->delete();
        return redirect()->route('admin.knowledge-base.index');
    }

    // --- Category Management (via AJAX atau modal) ---

    public function categoryStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:kb_categories,name',
            'description' => 'nullable|string',
        ]);

        $category = KbCategoryModel::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return response()->json(['success' => true, 'message' => 'Kategori berhasil ditambahkan!', 'category' => $category]);
    }

    public function categoryUpdate(Request $request, KbCategoryModel $category)
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

    public function categoryDestroy(KbCategoryModel $category)
    {
        if ($category->articles()->count() > 0) {
            return response()->json(['success' => false, 'message' => 'Tidak bisa menghapus kategori yang memiliki artikel!'], 400);
        }

        $category->delete();
        return response()->json(['success' => true, 'message' => 'Kategori berhasil dihapus!']);
    }

    // --- Summernote Image Upload ---

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/kb_images'), $imageName); // Simpan di public/storage/kb_images

            // Pastikan Anda telah menjalankan `php artisan storage:link` sebelumnya
            return response()->json(['url' => asset('storage/kb_images/' . $imageName)]);
        }

        return response()->json(['error' => 'Gagal mengunggah gambar'], 400);
    }
}
