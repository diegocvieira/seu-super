<?php

namespace App\Http\Controllers\Admin\Nosuper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Models\Category;
use Str;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::with('category')
            ->orderBy('name', 'ASC')
            ->get();

        return view('admin.nosuper.subcategory.index', compact('subcategories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->get();

        return view('admin.nosuper.subcategory.create-edit', compact('categories'));
    }

    public function store(Request $request)
    {
        Subcategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'category_id' => $request->category
        ]);

        session()->flash('session_flash', 'Subcategoria cadastrada!');

        return redirect()->route('nosuper.subcategory.index');
    }

    public function edit($id)
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $subcategory = Subcategory::findOrFail($id);

        return view('admin.nosuper.subcategory.create-edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $subcategory = Subcategory::findOrFail($id);

        $subcategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'category_id' => $request->category
        ]);

        session()->flash('session_flash', 'Subcategoria atualizada!');

        return redirect()->route('nosuper.subcategory.index');
    }

    public function delete($id)
    {
        Subcategory::findOrFail($id)->delete();

        session()->flash('session_flash', 'Subcategoria deletada!');

        return redirect()->route('nosuper.subcategory.index');
    }
}
