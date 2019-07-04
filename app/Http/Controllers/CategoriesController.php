<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    public function index()
    {
        $c = new Category();
        $categories = Category::all();
        return view('admin.categories', compact('c', 'categories'));
    }

    public function store(Request $request)
    {
        Category::create(request()->validate([
            'name' => 'required|min:3'
        ],[
            'name.required' => 'É necessário informar um nome a categoria',
            'name.min' => 'A categoria deve conter no mínimo 3 caracteres'
        ]));

        return back();
    }

    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    public function singleCategory($slug){
        $category = Category::where(['name' => $slug])->firstOrFail();

        return view('categories.singlecategory', compact('category'));
    }
}
