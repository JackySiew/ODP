<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Sliders;


class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Sliders::all()->sortByDesc('created_at');
        return view('admin.slider.index',compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'heading' => 'required',
        //     'description' => 'required',
        //     'link' => 'required',
        //     'link_name' => 'required',
        //     'image' => 'image|nullable|max:5000'
        // ]);
        $sliders = new Sliders;
        $sliders->heading = $request->input('heading');
        $sliders->description = $request->input('description');
        $sliders->link = $request->input('link');
        $sliders->link_name = $request->input('link_name');        
        if ($request->hasFile('image')) {
            $fileNameWithExt = $request->file('image')->getClientOriginalName();

            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            $extension = $request->file('image')->getClientOriginalExtension();

            $fileNameToStore = $filename.'_'.time().'_'.$extension;

            // $request->file('image')->storeAs('public/slide', $fileNameToStore);
            // $request->file('image')->storeAs('storage/slide', $fileNameToStore);
            // $request->file('image')->storeAs('/storage/slide', $fileNameToStore);
            // $request->file('image')->move('public/slide', $fileNameToStore);
            $request->file('image')->move('storage/slide', $fileNameToStore);
        }else {
            $fileNameToStore = "noimage.png";
        }
        
        $sliders->image = $fileNameToStore;
        $sliders->status = $request->input('status') == true ? '1':'0';

        $sliders->save();

        return redirect('/slider')->with('success','Slider Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slider = Sliders::find($id);
        return view('admin.slider.edit',compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $slider = Sliders::find($id);
        $slider->heading = $request->input('heading');
        $slider->description = $request->input('description');
        $slider->link = $request->input('link');
        $slider->link_name = $request->input('link_name');        

        if ($request->hasFile('image')) {
            $destination = 'storage/slide/'.$slider->image;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $fileNameWithExt = $request->file('image')->getClientOriginalName();

            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            $extension = $request->file('image')->getClientOriginalExtension();

            $fileNameToStore = $filename.'_'.time().'_'.$extension;

            // $request->file('image')->storeAs('public/slide', $fileNameToStore);
            // $request->file('image')->storeAs('storage/slide', $fileNameToStore);
            // $request->file('image')->storeAs('/storage/slide', $fileNameToStore);
            // $request->file('image')->move('public/slide', $fileNameToStore);
            $request->file('image')->move('storage/slide', $fileNameToStore);
        }else {
            $fileNameToStore = $slider->image;
        }
        
        $slider->image = $fileNameToStore;
        $slider->status = $request->input('status') == true ? '1':'0';

        $slider->save();

        return redirect('/slider')->with('status','Slider Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
