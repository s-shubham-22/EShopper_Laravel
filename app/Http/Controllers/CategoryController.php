<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\StoreCategory;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.category.index', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategory $request)
    {
        $validated = $request->validated();
        $category = new Category($validated);

        $category->name = $validated['name'];
        $category->slug = Str::slug($validated['name']);
        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('/uploads/category'), $filename);
            $category->image = $filename;
        }
        if($category->save()) {
            $request->session()->flash('success', 'Category Created Successfully!');
        } else {
            $request->session()->flash('error', 'Category not Created!');
        }
        
        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit', [
            'category' => Category::find($category->id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategory $request,  $id)
    {
        $validated = $request->validated();
        $category = Category::find($id);

        $category->name = $validated['name'];
        $category->slug = Str::slug($validated['name']);
        if(isset($validated['image']) && $validated['image'] != null){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('/uploads/category'), $filename);
            File::delete(public_path('/uploads/category/'.$category->image));
            $category->image = $filename;
        }
        if($category->save()) {
            return redirect()->route('category.index')->with('success', 'Category Updated Successfullyz!');
        } else {
            return redirect()->route('category.index')->with('error', 'Category not Updated!');
        }
        
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if($category->delete()) {
            return redirect()->route('category.index')->with('success', 'Category Deleted Successfully!');
        } else {
            return redirect()->route('category.index')->with('error', 'Category not Deleted!');
        }
    }

    public function change_status(Request $request)
    {
        
        $category = Category::find($request->id);
        $category->status = $request->status;
        if($category->save()) {
            return response()->json(['success' => 'Status Changed Successfully!', 'status' => $request->status]);
        } else {
            return response()->json(['error' => 'Status not Changed!']);
        }
    }
}
