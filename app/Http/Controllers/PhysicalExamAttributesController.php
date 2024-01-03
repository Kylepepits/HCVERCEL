<?php

namespace App\Http\Controllers;

use App\Models\PhysicalExam_Attributes;
use App\Models\PhysicalExam_categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class PhysicalExamAttributesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PhysicalExam_Attributes::orderByRaw('LENGTH(PEA_id) ASC')->orderByRaw('LENGTH(physicalExam_id) ASC')->get();;

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $physicalExam_id = PhysicalExam_categories::where('physicalExam_id', $request['physicalExam_id'])->first()->physicalExam_id;
        $latestorder = PhysicalExam_Attributes::where('physicalExam_id', $request['physicalExam_id'])->count();
        $currentId =  $physicalExam_id . 'PEA' . $latestorder;

        if( !empty(PhysicalExam_Attributes::select('PEA_id')->where('PEA_id', $currentId)->first()->PEA_id)){
        do{
            $latestorder++;
            $PEA_id = $physicalExam_id . 'PEA' . $latestorder;
            $id = PhysicalExam_Attributes::select('PEA_id')->where('PEA_id', $PEA_id)->first();
         
        }while(!empty($id));
        }

         $newId = $physicalExam_id . 'PEA' . $latestorder;

         PhysicalExam_Attributes::insert([
           
            'PEA_id' => $newId,
            'PEA_name' => $request['PEA_name'],
            'PEA_dataType' => 'integer',
            'physicalExam_id' => $request['physicalExam_id'],


            'created_at' => now(),
            'updated_at' => now(),
        ]);




        if( !empty(PhysicalExam_Attributes::select('PEA_id')->where('PEA_id', $currentId)->first()->PEA_id)){
            do{
                $latestorder++;
                $PEA_id = $physicalExam_id . 'PEA' . $latestorder;
                $id = PhysicalExam_Attributes::select('PEA_id')->where('PEA_id', $PEA_id)->first();
             
            }while(!empty($id));
            }

        $specifyId = $physicalExam_id . 'PEA' . $latestorder+1;
        PhysicalExam_Attributes::insert([
           
            'PEA_id' => $specifyId,
            'PEA_name' => 'specify_' . $request['PEA_name'],
            'PEA_dataType' => 'string',
            'physicalExam_id' => $request['physicalExam_id'],


            'created_at' => now(),
            'updated_at' => now(),
        ]);


        $action ='added a new Physical Exam Attribute';

         $log = new ResActionLogController;
        $log->store(Auth::user(), $action);
        return response('stored');
    }

    /**
     * Display the specified resource.
     */
    public function show(PhysicalExam_Attributes $physicalExam_Attributes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PhysicalExam_Attributes $physicalExam_Attributes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $PEA = PhysicalExam_Attributes::where('PEA_id', $id)->first();
        $action ='deleted a Physical Exam Attribute-'. $PEA['PEA_name'];
        $log = new ResActionLogController;
        $log->store(Auth::user(), $action);
        PhysicalExam_Attributes::destroy($id);

       
        return response('deleted');
    }
}
