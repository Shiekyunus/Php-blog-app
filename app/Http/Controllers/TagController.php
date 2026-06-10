<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Http\Requests\TagRequest;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Apply authentication and permission middleware to the controller actions.
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show','showArticles']);
        $this->middleware('permission:manage tags')->only(['create', 'store', 'edit', 'update']);
        $this->middleware('permission:delete tags')->only('destroy');
    }
    // Display a listing of the resource.
    public function index()
    {
        //
        $tags = Tag::latest()->paginate(5);
        return view('tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // Show the form for creating a new tag.
    public function create()
    {
        //
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // Store a newly created tag in storage.
    public function store(TagRequest $request)
    {
        //
        $validated = $request->validated();
        $slug = Str::slug($validated['name']);
        if (Tag::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }
        Tag::create([
            'name' => $validated['name'],
            'slug' => $slug,
        ]);
        return redirect()->route('tags.index')->with('success', 'Tag Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    // Display the details of a specific tag and count the number of articles associated with it.
    public function show(Tag $tag)
    {
        //
        $tag->loadCount('articles');
        return view('tags.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // Show the form for editing a specific tag.
    public function edit(Tag $tag)
    {
        //
        return view('tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    // Update the details of a specific tag in storage.
    public function update(TagRequest $request, Tag $tag)
    {
        //
        $validated = $request->validated();
        $slug = Str::slug($validated['name']);
        if (
            Tag::where('slug', $slug)->where('id', '!=', $tag->id)->exists()
        ) {
            $slug .= '-' . time();
        }
        $tag->update([
            'name' => $validated['name'],
            'slug' => $slug,
        ]);
        return redirect()->route('tags.index')->with('success', 'tag updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    // Remove a specific tag from storage.
    public function destroy(Tag $tag)
    {
        //
        $tag->delete();
        return redirect()->route('tags.index')->with('success', 'Tag Deleted successfully!');
    }
    // Display a list of published articles associated with a specific tag.
    public function showArticles(Tag $tag)
    {
        $articles = $tag->articles()->with(['author','category','tags'])->where('is_published', true)->latest()->paginate(6);
        return view('home', compact('articles', 'tag'));
    }
}
