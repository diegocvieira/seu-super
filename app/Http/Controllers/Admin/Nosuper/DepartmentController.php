<?php

namespace App\Http\Controllers\Admin\Nosuper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use Str;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::orderBy('name', 'ASC')->get();

        return view('admin.nosuper.department.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.nosuper.department.create-edit');
    }

    public function store(Request $request)
    {
        Department::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'image' => _saveImageFolder($request->image, 'departments')
        ]);

        session()->flash('session_flash', 'Departamento cadastrado!');

        return redirect()->route('nosuper.department.index');
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);

        return view('admin.nosuper.department.create-edit', compact('department'));
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

        session()->flash('session_flash', 'Departamento atualizado!');

        return redirect()->route('nosuper.department.index');
    }

    public function delete($id)
    {
        Department::findOrFail($id)->delete();

        session()->flash('session_flash', 'Departamento deletado!');

        return redirect()->route('nosuper.department.index');
    }
}
