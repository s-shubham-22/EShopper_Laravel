<?php

namespace App\Http\Controllers;

use App\Models\Variant;
use App\Http\Requests\VariantRequest;
use Illuminate\Http\Request;
use File;

class VariantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.variant.index', [
            'variants' => Variant::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('admin.variant.create', [
            'product_id' => $id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VariantRequest $request)
    {
        $validated = $request->validated();
        $variant = Variant::create([
            'product_id' => $validated['product_id'],
            'image' => $validated['image'],
            'color' => $validated['color'],
            'size' => $validated['size'],
            'quantity' => $validated['quantity'],
            'price' => $validated['price'],
            'sale_price' => $validated['sale_price']
        ]);

        $upload_dir='variant';
        if(isset($request->image) && !empty($request->image))
        {
            $microtime=microtime();
            $microtime=str_replace('.','', $microtime);
            $microtime=str_replace(' ','', $microtime);
            $fileName = $microtime.'.'.$request->image->extension();
            if($request->image->move(public_path('uploads/'.$upload_dir), $fileName))
            {
                $fileupload_data = Variant::where('id',$variant->id)->update([
                    'image' => $fileName
                ]);
            }
        }

        return redirect()->route('variant.show', $validated['product_id'])->with('success', 'Variant created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Variant  $variant
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.variant.show', [
            'variants' => Variant::where('product_id', $id)->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Variant  $variant
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        return view('admin.variant.edit', [
            'variant' => Variant::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Variant  $variant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'color' => 'required|max:255',
            'size' => 'required|max:255',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $variant = Variant::find($id);

        $variant->color = $validated['color'];
        $variant->size = $validated['size'];
        $variant->quantity = $validated['quantity'];
        $variant->price = $validated['price'];
        $variant->sale_price = $validated['sale_price'];

        $upload_dir='variant';
        if(isset($request->image) && !empty($request->image))
        {
            $microtime=microtime();
            $microtime=str_replace('.','', $microtime);
            $microtime=str_replace(' ','', $microtime);
            $fileName = $microtime.'.'.$request->image->extension();
            if($request->image->move(public_path('uploads/'.$upload_dir), $fileName))
            {
                File::delete(public_path('uploads/'.$upload_dir.'/'.$variant->image));
                $fileupload_data = Variant::where('id',$variant->id)->update([
                    'image' => $fileName
                ]);
            }
        }
        $variant->save();

        return redirect()->route('variant.show', $variant->product_id)->with('success', 'Variant Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Variant  $variant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $variant = Variant::find($id);
        $product_id = $variant->product_id;
        if(Variant::where('product_id', $product_id)->count() > 1){
            if($variant->delete()) {
                return redirect()->route('variant.show', $product_id)->with('success', 'Variant Deleted Successfully!');
            } else {
                return redirect()->route('variant.show', $product_id)->with('error', 'Variant not Deleted!');
            }
        } else {
            return redirect()->route('variant.show', $product_id)->with('error', 'Atleast 1 Variant is Required!');
        }
    }

    public function change_status(Request $request)
    {
        
        $variant = Variant::find($request->id);
        $variant->status = $request->status;
        if($variant->save()) {
            return response()->json(['success' => 'Status Changed Successfully!', 'status' => $request->status]);
        } else {
            return response()->json(['error' => 'Status not Changed!']);
        }
    }    
}
