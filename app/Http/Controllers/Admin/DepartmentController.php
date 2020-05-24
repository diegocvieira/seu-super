<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use Str;

class DepartmentController extends Controller
{
    public function create()
    {
        return view('admin.department.create-edit');
    }

    public function store(Request $request)
    {
        $department = Department::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'image' => _saveImageFolder($request->image, 'departments')
        ]);
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);

        return view('admin.department.create-edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $department->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-')
        ]);

        if ($request->image) {
            $department->update([
                'image' => _saveImageFolder($request->image, 'departments')
            ]);
        }
    }
}
