<?php

namespace App\Http\Controllers\Admin\Nosuper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Department;
use Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('department')
            ->orderBy('name', 'ASC')
            ->get();

        return view('admin.nosuper.category.index', compact('categories'));
    }

    public function create()
    {
        $departments = Department::orderBy('name', 'ASC')->get();

        return view('admin.nosuper.category.create-edit', compact('departments'));
    }

    public function store(Request $request)
    {
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'department_id' => $request->department
        ]);

        session()->flash('session_flash', 'Categoria cadastrada!');

        return redirect()->route('nosuper.category.index');
    }

    public function edit($id)
    {
        $departments = Department::orderBy('name', 'ASC')->get();
        $category = Category::findOrFail($id);

        return view('admin.nosuper.category.create-edit', compact('category', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'department_id' => $request->department
        ]);

        session()->flash('session_flash', 'Categoria atualizada!');

        return redirect()->route('nosuper.category.index');
    }

    public function delete($id)
    {
        Category::findOrFail($id)->delete();

        session()->flash('session_flash', 'Categoria deletada!');

        return redirect()->route('nosuper.category.index');
    }
}
