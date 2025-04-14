<?php

namespace App\Http\Controllers;

use App\Models\DocumentMaintenanceTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentMaintenanceTaskApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        try {
            DB::beginTransaction();
            if(isset($request->type)){
                if($request->type=="Associer"){
                    foreach ($request['maintenances'] as $value) {
                        # code...
                        DocumentMaintenanceTask::firstOrCreate(['maintenance_id' => $value, 'document_id' => $request->document_id]);
                    }
                    foreach ($request['tasks'] as $value) {
                        # code...
                        DocumentMaintenanceTask::firstOrCreate(['task_id' => $value, 'document_id' => $request->document_id]);
                    }
                }
                if($request->type=="Dissocier"){
                    foreach ($request['maintenances'] as $value) {
                        DocumentMaintenanceTask::where('maintenance_id', $value)
                            ->where('document_id', $request->document_id)
                            ->delete();
                    }
                    foreach ($request['tasks'] as $value) {
                        DocumentMaintenanceTask::where('task_id', $value)
                            ->where('document_id', $request->document_id)
                            ->delete();
                    }

                }

                DB ::commit();
                // return response()->json(['data' => $document], 201);
            }
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => $e->getMessage()], 500);
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(DocumentMaintenanceTask $documentMaintenanceTask)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DocumentMaintenanceTask $documentMaintenanceTask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DocumentMaintenanceTask $documentMaintenanceTask)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentMaintenanceTask $documentMaintenanceTask)
    {
        //
    }
}
