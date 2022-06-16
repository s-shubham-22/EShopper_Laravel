<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variant;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Str;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.index', [
            'products' => Product::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product.create', [
            'categories' => Category::all(),
            'brands' => Brand::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']);
        $product = Product::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'full_description' => $validated['full_description'],
            'category_id' => $validated['category_id'],
            'brand_id' => $validated['brand_id']
        ]);
        $variant = Variant::create([
            'product_id' => $product->id,
            'image' => $validated['image'],
            'color' => $validated['color'],
            'size' => $validated['size'],
            'quantity' => $validated['quantity'],
            'price' => $validated['price'],
            'sale_price' => $validated['sale_price']
        ]);

        $upload_dir='product';
        if(isset($request->image) && !empty($request->image))
        {
            $microtime=microtime();
            $microtime=str_replace('.','', $microtime);
            $microtime=str_replace(' ','', $microtime);
            $fileName = $microtime.'.'.$request->image->extension();
            if($request->image->move(public_path('uploads/product'), $fileName))
            {
                File::copy(public_path('uploads/product/'.$fileName), public_path('uploads/variant/'.$fileName));
                $fileupload_data = Product::where('id',$product->id)->update([
                    'image' => $fileName
                ]);
                $fileupload_data = Variant::where('id',$variant->id)->update([
                    'image' => $fileName
                ]);
            }
        }

        return redirect()->route('product.index')->with('success', 'Product Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.product.edit', [
            'product' => Product::find($product->id),
            'categories' => Category::all(),
            'brands' => Brand::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'full_description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $product = Product::find($id);
        $product->name = $validated['name'];
        $product->slug = Str::slug($validated['name']);
        $product->description = $validated['description'];
        $product->full_description = $validated['full_description'];
        $product->category_id = $validated['category_id'];
        $product->brand_id = $validated['brand_id'];

        $upload_dir='product';
        if(isset($request->image) && !empty($request->image))
        {
            $microtime=microtime();
            $microtime=str_replace('.','', $microtime);
            $microtime=str_replace(' ','', $microtime);
            $fileName = $microtime.'.'.$request->image->extension();
            if($request->image->move(public_path('uploads/'.$upload_dir), $fileName))
            {
                File::delete(public_path('uploads/'.$upload_dir.'/'.$product->image));
                $fileupload_data = Product::where('id',$product->id)->update([
                    'image' => $fileName
                ]);
            }
        }
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if($product->delete()) {
            Variant::where('product_id',$id)->delete();
            return redirect()->route('product.index')->with('success', 'Product Deleted Successfully!');
        } else {
            return redirect()->route('product.index')->with('error', 'Product not Deleted!');
        }
    }
    
    public function change_status(Request $request)
    {
        
        $product = Product::find($request->id);
        $product->status = $request->status;
        if($product->save()) {
            return response()->json(['success' => 'Status Changed Successfully!', 'status' => $request->status]);
        } else {
            return response()->json(['error' => 'Status not Changed!']);
        }
    }
}
