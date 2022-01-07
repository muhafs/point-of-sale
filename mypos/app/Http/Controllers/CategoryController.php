<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //! INDEX
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    //! CREATE
    public function create()
    {
        return view('admin.categories.create');
    }

    //! STORE
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|unique:categories',
        ]);

        Category::create($request->all());

        return redirect('categories')->with('success', 'Category has been added successfully');
    }

    //! EDIT
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    //! UPDATE
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => "required|unique:categories,name,{$category->id}",
        ]);

        $category->update($request->all());

        return redirect('categories')->with('success', 'Category has been updated successfully');
    }

    //! DESTROY
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect('categories')->with('success', 'Category has been deleted successfully');
    }
}
