<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Outlet;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Ambil parameter pencarian dari query string
        $searchName = $request->input('name');
        
        // Query untuk mendapatkan kategori sesuai dengan outlet_id dan nama kategori jika ada pencarian
        $categories = Category::when($searchName, function($query) use ($searchName) {
                return $query->where('name', 'like', '%' . $searchName . '%');
            })
            ->paginate(10);

        // Menambahkan parameter pencarian pada pagination link
        $categories->appends(['name' => $searchName]);

        return view('dashboard.categories.index', [
            'categories' => $categories,
            'outlets' => Outlet::all()
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create', [
            'categories' => Category::all(),
            'outlets' => Outlet::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:categories|string'
        ]);

        $validateData['outlet_id'] = Outlet::first()->get('id');
        Category::create($validateData);

        return redirect('/dashboard/categories')->with('success', 'New Category has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $Category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $Category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:categories|string'
        ]);

        $validateData['outlet_id'] = Outlet::first()->get('id');

        Category::where('id', $category->id)
                ->update([
                    'name' => $validateData['name']
                ]);

        return redirect('/dashboard/categories')->with('success', 'New Category has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $Category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        Category::destroy($category->id);
        return redirect('/dashboard/categories')->with('success', 'Category has been deleted!');
    }
}
