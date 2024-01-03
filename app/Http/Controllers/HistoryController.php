<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $time = now();
        $date = new Carbon( $time ); 

        $latestOrder = History::all()->count();
        $currentId = 'H' . $date->year . '-' . $latestOrder;

        if( !empty(History::select('history_id')->where('history_id', $currentId)->first()->history_id)){
            do{
                $latestorder++;
                $histId = 'H' . $date->year . '-' . $latestOrder;
                $id = History::select('history_id')->where('history_id',$histId)->first();
             
            }while(!empty($id));
        }

        $newId = 'H' . $date->year . '-' . $latestOrder;

        History::insert([ 
            'history_id' => $newId,
      

            'created_at' => now(),
            'updated_at' => now()
       ]);
    
   

       $action ='created a new History';

       $user = Auth::user();
       if($user['role'] != 'admin'){
       $log = new ResActionLogController;
       $log->store(Auth::user(), $action);
       }

       return $newId;
    }

    /**
     * Display the specified resource.
     */
    public function show(History $history)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, History $history)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(History $history)
    {
        //
    }
}
