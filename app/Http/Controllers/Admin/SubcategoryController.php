<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Models\Category;
use Str;

class SubcategoryController extends Controller
{
    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->get();

        return view('admin.subcategory.create-edit', compact('categories'));
    }

    public function store(Request $request)
    {
        $subcategory = Subcategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'category_id' => $request->category
        ]);
    }

    public function edit($id)
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $subcategory = Subcategory::findOrFail($id);

        return view('admin.subcategory.create-edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $subcategory = Subcategory::findOrFail($id);

        $subcategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'category_id' => $request->category
        ]);
    }
}
