<?php

namespace App\Http\Controllers;

use App\Models\resident;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ResidentController extends Controller
{
           


        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = resident::all();

        return $data;
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
        
        $latestorder = resident::all()->count();
        resident::insert([
            'resident_id' => 'R' . $latestorder,
            'resident_userName' => $request['resident_userName'],
            'resident_fName' => $request['resident_fName'],
            'resident_lName' => $request['resident_lName'],
            'resident_mName' => $request['resident_mName'],
            'resident_password' => $request['resident_password'],
            'department_id' => $request['department_id'],
            'isChief' => $request['isChief'],
            
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response('store');
    }

    /**
     * Display the specified resource.
     */
    public function show($residentId)
    {
        try{
            $resident = Resident::findOrFail($residentId);
            return response()->json($resident);
        }catch(\Exception $e){
            return response()->json(['error'=>'resident not found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {   

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $dataToUpdate = [
            'resident_userName' => $request['resident_userName'],
            'resident_fName' => $request['resident_fName'],
            'resident_lName' => $request['resident_lName'],
            'resident_mName' => $request['resident_mName'],
            'department_id' => $request['department_id'],
            'isChief' => $request['isChief'],
            'updated_at' => now(),
        ];

        // Check if the password field is empty, if so, remove it from the update array
        if (empty($request['resident_password'])) {
            unset($dataToUpdate['resident_password']);
        } else {
            // If the password is not empty, update it in the array
            $dataToUpdate['resident_password'] = $request['resident_password'];
        }

        resident::where('resident_id', $id)->update($dataToUpdate);

        return response('updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       resident::destroy($id);

       return response('deleted');
    }


    public function updateResident(Request $request, $id)
    {
       
        
        resident::where('resident_id', $id)->update(
            [
                'resident_userName' => $request['resident_userName'],
                'resident_fName' => $request['resident_fName'],
                'resident_lName' => $request['resident_lName'],
                'resident_mName' => $request['resident_mName'],
                'resident_password' => $request['resident_password'],
                'department_id' => $request['department_id'],
                'isChief' => $request['isChief'],
         
                'updated_at' => now(),
                ]
        );


        return response('updated');
    }

  
   
}
