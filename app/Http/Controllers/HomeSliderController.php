<?php

namespace App\Http\Controllers;

use App\Models\HomeSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\HomeSliderRequest;
use Illuminate\Support\Facades\File;

class HomeSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.home_slider.index', [
            'home_sliders' => HomeSlider::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.home_slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HomeSliderRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']);
        $slider = HomeSlider::create($validated);

        $upload_dir='slider';
        if(isset($request->image) && !empty($request->image))
        {
            $microtime=microtime();
            $microtime=str_replace('.','', $microtime);
            $microtime=str_replace(' ','', $microtime);
            $fileName = $microtime.'.'.$request->image->extension();
            if($request->image->move(public_path('uploads/'.$upload_dir), $fileName))
            {
                $fileupload_data = HomeSlider::where('id',$slider->id)->update([
                    'image' => $fileName
                ]);
            }
        }
        
        return redirect()->route('home-slider.index')->with('success', 'Slider Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HomeSlider  $homeSlider
     * @return \Illuminate\Http\Response
     */
    public function show(HomeSlider $homeSlider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomeSlider  $homeSlider
     * @return \Illuminate\Http\Response
     */
    public function edit(HomeSlider $home_slider)
    {
        return view('admin.home_slider.edit', [
            'home_slider' => $home_slider
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HomeSlider  $homeSlider
     * @return \Illuminate\Http\Response
     */
    public function update(HomeSliderRequest $request, $homeSlider)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']);
        HomeSlider::find($homeSlider)->update($validated);

        $upload_dir='slider';
        if(isset($request->image) && !empty($request->image))
        {
            $microtime=microtime();
            $microtime=str_replace('.','', $microtime);
            $microtime=str_replace(' ','', $microtime);
            $fileName = $microtime.'.'.$request->image->extension();
            if($request->image->move(public_path('uploads/'.$upload_dir), $fileName))
            {
                File::delete(public_path('uploads/'.$upload_dir.'/'.HomeSlider::find($homeSlider)->image));
                $fileupload_data = HomeSlider::where('id',$homeSlider)->update([
                    'image' => $fileName
                ]);
            }
        }

        return redirect()->route('home-slider.index')->with('success', 'Slider Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HomeSlider  $homeSlider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = HomeSlider::find($id);
        if($slider->delete()) {
            return redirect()->route('home-slider.index')->with('success', 'Slider Deleted Successfully!');
        } else {
            return redirect()->route('home-slider.index')->with('error', 'Slider not Deleted!');
        }
    }

    public function change_status(Request $request)
    {
        $slider = HomeSlider::find($request->id);
        $slider->status = $request->status;
        if($slider->save()) {
            return response()->json(['success' => 'Status Changed Successfully!', 'status' => $request->status]);
        } else {
            return response()->json(['error' => 'Status not Changed!']);
        }
    }
}
