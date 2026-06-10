<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Apply authentication and permission middleware to the controller actions.
    public function __construct()
    {

        $this->middleware('auth')->except('index', 'showArticles', 'show');
        $this->middleware('permission:manage categories')->only(['create','store','edit','update']);
        $this->middleware('permission:delete categories')->only('destroy');
    }
    // Display a listing of the categories.
    public function index()
    {
        //
        $categories = Category::latest()->paginate(9);
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // Show the form for creating a new category.
    public function create()
    {
        //
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // Store a newly created category in storage.
    public function store(CategoryRequest $request)
    {
        //
        $validated = $request->validated();
        $slug = Str::slug($validated['name']);
        if (Category::where('slug', $slug)->exists()) {
            $slug .= '-'.time();
        }
        Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
        ]);
        return redirect()->route('categories.index')->with('success', 'Category Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    // Display the specified category along with the count of published articles.
    public function show(Category $category)
    {
        //
        $category->loadCount(['articles as published_articles_count' => function ($query) {
            $query->where('is_published', true);
        }]);
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // Show the form for editing the specified category.
    public function edit(Category $category)
    {
        //
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    // Update the specified category in storage.
    public function update(CategoryRequest $request, Category $category)
    {
        //
        $validated = $request->validated();
        $slug = Str::slug($validated['name']);
        if (
            Category::where('slug', $slug)
              ->where('id', '!=', $category->id)
              ->exists()
        ) {
            $slug .= '-'.time();
        }
        $category->update([
           'name' => $validated['name'],
           'slug' => $slug,
           'description' => $validated['description'] ?? null,
        ]);
        return redirect()->route('categories.index')->with('success', 'Category Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    // Remove the specified category from storage.
    public function destroy(Category $category)
    {
        //
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category Deleted Successfully!');
    }
    // Display a listing of the articles for the specified category.
    public function showArticles(Category $category)
    {
        $articles = $category->articles()->with(['author','category','tags'])->where('is_published', true)->latest()->paginate(6);

        return view('home', compact('articles', 'category'));
    }
}
