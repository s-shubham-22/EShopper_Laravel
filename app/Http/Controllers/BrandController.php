<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\BrandRequest;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.brand.index', [
            'brands' => Brand::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']);

        $brand = Brand::create($validated);

        $upload_dir='brand';
        if(isset($request->image) && !empty($request->image))
        {
            $microtime=microtime();
            $microtime=str_replace('.','', $microtime);
            $microtime=str_replace(' ','', $microtime);
            $fileName = $microtime.'.'.$request->image->extension();
            if($request->image->move(public_path('uploads/'.$upload_dir), $fileName))
            {
                $fileupload_data = Brand::where('id',$brand->id)->update([
                    'image' => $fileName
                ]);
            }
        }
        
        return redirect()->route('brand.index')->with('success', 'Brand Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        return view('admin.brand.edit', [
            'brand' => Brand::find($brand->id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request,  $id)
    {
        $validated = $request->validated();
        $brand = Brand::find($id);

        $brand->name = $validated['name'];
        $brand->slug = Str::slug($validated['name']);
        if(isset($validated['image']) && $validated['image'] != null){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('/uploads/brand'), $filename);
            File::delete(public_path('/uploads/brand/'.$brand->image));
            $brand->image = $filename;
        }
        if($brand->save()) {
            return redirect()->route('brand.index')->with('success', 'Brand Updated Successfullyz!');
        } else {
            return redirect()->route('brand.index')->with('error', 'Brand not Updated!');
        }
        
        return redirect()->route('brand.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);
        if($brand->delete()) {
            return redirect()->route('brand.index')->with('success', 'Brand Deleted Successfully!');
        } else {
            return redirect()->route('brand.index')->with('error', 'Brand not Deleted!');
        }
    }

    public function change_status(Request $request)
    {
        
        $brand = Brand::find($request->id);
        $brand->status = $request->status;
        if($brand->save()) {
            return response()->json(['success' => 'Status Changed Successfully!', 'status' => $request->status]);
        } else {
            return response()->json(['error' => 'Status not Changed!']);
        }
    }
}
