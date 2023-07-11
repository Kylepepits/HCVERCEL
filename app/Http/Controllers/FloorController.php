<?php

namespace App\Http\Controllers;

use App\Models\floor;
use Illuminate\Http\Request;

class FloorController extends Controller
{
       /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dep = floor::all();

        return view('practiceDep')->with('deps' , $dep);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        floor::insert([
            'floor_id' => $request['floor_id'],
            'floor_name' => $request['floor_name'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return view('practiceDep');
    }

    /**
     * Display the specified resource.
     */
    public function show(floor $floor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {   
        $floor = floor::where('floor_id', $id)->get();
        return view('editDep')->with('floor', $floor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       
        
        floor::where('floor_id', $id)->update(['floor_name' => $request['floor_name'],          'updated_at' => now(),]);

        return redirect(route('floors.index'))->with('message','dep has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       floor::destroy($id);

       return redirect(route('floors.index'))->with('message','dep has been deleted');
    }


    public function updateFloor(Request $request, $id)
    {
       
        
        floor::where('floor_id', $id)->update(['floor_name' => $request['floor_name'],          'updated_at' => now(),]);

        return redirect(route('floors.index'))->with('message','dep has been updated');
    }

}
