<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Department;
use Str;

class CategoryController extends Controller
{
    public function create()
    {
        $departments = Department::orderBy('name', 'ASC')->get();

        return view('admin.category.create-edit', compact('departments'));
    }

    public function store(Request $request)
    {
        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'department_id' => $request->department
        ]);
    }

    public function edit($id)
    {
        $departments = Department::orderBy('name', 'ASC')->get();
        $category = Category::findOrFail($id);

        return view('admin.category.create-edit', compact('category', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'department_id' => $request->department
        ]);
    }
}
