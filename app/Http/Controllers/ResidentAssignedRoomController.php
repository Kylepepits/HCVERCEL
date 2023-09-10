<?php

namespace App\Http\Controllers;

use App\Models\resident;
use App\Models\resident_assigned_room;
use App\Models\room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ResidentAssignedRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
           
        $data = resident_assigned_room::all();
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
    {   $time = now();
        $date = new Carbon( $time ); 


        resident_assigned_room::insert([
            'resAssRoom_id' => $date->year . $request['resident_id'] .  $request['room_id'],
            'resident_id' => $request['resident_id'],
            'room_id' => $request['room_id'],
            'isFinished' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $roomName = RoomController::getRoomNamebyId($request['room_id']);
        $lname = resident::select('resident_lName')->where('resident_id', $request['resident_id'])->first()->resident_lName;
        $fname = resident::select('resident_fName')->where('resident_id', $request['resident_id'])->first()->resident_fName;
        $mname = resident::select('resident_mName')->where('resident_id', $request['resident_id'])->first()->resident_mName;


        $residentName = $lname . ', ' . $fname . ' ' . $mname;
        $action ='assigned room-'. $roomName.' to resident-'. $residentName;
        app('App\Http\Controllers\resActionLogController')->store(Auth::user(), $action);
    }

    /**
     * Display the specified resource.
     */
    public function show($resident_id)
    {
        $assignedRooms = resident_assigned_room::where('resident_id', $resident_id)->get();


        return response()->json($assignedRooms);
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(resident_assigned_room $resident_assigned_room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, resident_assigned_room $resident_assigned_room)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $RAR = resident_assigned_room::where('resAssRoom_id', $id)->first();

        $roomName = RoomController::getRoomNamebyId($RAR['room_id']);
        $lname = resident::select('resident_lName')->where('resident_id', $RAR['resident_id'])->first()->resident_lName;
        $fname = resident::select('resident_fName')->where('resident_id', $RAR['resident_id'])->first()->resident_fName;
        $mname = resident::select('resident_mName')->where('resident_id', $RAR['resident_id'])->first()->resident_mName;


        $residentName = $lname . ', ' . $fname . ' ' . $mname;
        $action ='unassigned resident-'. $residentName . ' from room-' . $roomName;
        app('App\Http\Controllers\resActionLogController')->store(Auth::user(), $action);
        
        resident_assigned_room::destroy($id);

       
       return response('deleted');
    }

    public function updatePInfo(Request $request, $id)
    {
       
        
        resident_assigned_room::where('ressAssRoom_id', $id)->update(
            [

            'room_id' => $request['room_id'],
            'resident_id' => $request['resident_id'],
            'isFinished' => $request['isFinished'],



            'updated_at' => now(),
        ]);

        $action ='updated Resident Assigned room where id-'. $id;
        app('App\Http\Controllers\resActionLogController')->store(Auth::user(), $action);
        return response('done');
    }



    public function showRessAssRoom($resident_id)
    {
        $rooms = resident_assigned_room::where('resident_id', $resident_id)->get();


        return response()->json($rooms);
    
    }


    public function residentName($resident_id)
    {
        $lname = resident::select('resident_lName')->where('resident_id', $resident_id)->first()->resident_lName;
        $fname = resident::select('resident_fName')->where('resident_id', $resident_id)->first()->resident_fName;
        $mname = resident::select('resident_mName')->where('resident_id', $resident_id)->first()->resident_mName;



        return response()->json(['lastName' => $lname, 'firstName' => $fname, 'middleName' => $mname]);
    }

    public function roomName($room_id)
    {
        $roomName = room::select('room_name')->where('room_id', $room_id)->first()->room_id;


        return response()->json($roomName);
    }

}
