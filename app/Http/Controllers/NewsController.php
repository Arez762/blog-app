<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the news.
     */
    public function index()
    {
        $news = News::with('category', 'user')->paginate(10);
        return view('news.index', compact('news'));
    }

    /**
     * Show the form for creating a new news article.
     */
    public function create()
    {
        $categories = Category::all();
        return view('news.create', compact('categories'));
    }

    /**
     * Store a newly created news article in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:news,title',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|boolean',
            'addImage.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $data = $request->all();
        $data['user_id'] = Auth::id();
    
        // Store thumbnail
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }
    
        // Store additional images
        if ($request->hasFile('addImage')) {
            $images = [];
            foreach ($request->file('addImage') as $image) {
                $images[] = $image->store('images', 'public');
            }
            $data['addImage'] = json_encode($images);
        }
    
        News::create($data);
    
        return redirect()->route('news.index')->with('success', 'News article created successfully.');
    }

    /**
     * Display the specified news article.
     */
    public function show($id)
    {
        $news = News::with('category', 'user')->findOrFail($id);
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified news article.
     */
    public function edit($id)
    {
        $news = News::findOrFail($id);
        $categories = Category::all();
        return view('news.edit', compact('news', 'categories'));
    }

    /**
     * Update the specified news article in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'addImage.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|boolean',
        ]);
    
        $news = News::findOrFail($id);
        $data = $request->all();
    
        // Update thumbnail
        if ($request->hasFile('thumbnail')) {
            if ($news->thumbnail) {
                Storage::disk('public')->delete($news->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }
    
        // Update additional images
        if ($request->hasFile('addImage')) {
            $images = [];
            foreach ($request->file('addImage') as $image) {
                $images[] = $image->store('images', 'public');
            }
            $data['addImage'] = json_encode($images);
        }
    
        $news->update($data);
    
        return redirect()->route('news.index')->with('success', 'News article updated successfully.');
    }

    /**
     * Remove the specified news article from storage.
     */
    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        return redirect()->route('news.index')->with('success', 'News article deleted successfully.');
    }
}
