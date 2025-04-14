<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentMaintenanceTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DocumentApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $documents = Document::with(['document_maintenance_tasks' => function ($query) {
                $query->with(['task', 'maintenance']);
            }])->get();

            $documents->load(['document_maintenance_tasks.task']);
            $documents2=  $documents->load(['document_maintenance_tasks.maintenance']);

            $documents = $documents->map(function ($document) {
                $document->tasks = $document->document_maintenance_tasks->map(function ($documentMaintenanceTask) {
                    return $documentMaintenanceTask->task ? $documentMaintenanceTask->task->id : null;
                })->filter()->values();
                unset($document->document_maintenance_tasks);
                return $document;
            });
            $documents = $documents->map(function ($document) {
                $document->maintenances = $document->document_maintenance_tasks->map(function ($documentMaintenanceTask) {
                    return $documentMaintenanceTask->maintenance ?  $documentMaintenanceTask->maintenance->id : null;
                })->filter()->values();
                unset($document->document_maintenance_tasks);
                return $document;
            });

            return response()->json(['data' => $documents]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       try {

            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                // 'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,jpg,jpeg,png', // Example file types and size limit
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            try {
                DB::beginTransaction();

                // $path = $request->file('file')->store('storageDoc', 'public');
                $fileName = uniqid() . '.' . $request->file('file')->getClientOriginalExtension();

                // Store the file with the generated name
               $request->file('file')->storeAs(
                    'storageDoc', // Directory where the file will be stored
                    $fileName,    // The unique file name
                    'public'      // The disk to use (in this case, 'public')
                );
                $path= 'storageDoc/'.$fileName;
                $document = Document::create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'path' => $path,
                ]);

                DB::commit();
                return response()->json(['data' => $document], 201);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => $e->getMessage()], 500);
            }

       } catch (\Throwable $th) {
        //throw $th;
        return $th->getMessage();
       }

    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        return response()->json(['data' => $document]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            // 'file' => 'sometimes|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            $data = $request->except('file');

            if ($request->hasFile('file')) {
                // Delete old file
                if ($document->path) {
                    Storage::disk('public')->delete($document->path);
                }

                // $path = $request->file('file')->store('storageDoc', 'public');
                $fileName = uniqid() . '.' . $request->file('file')->getClientOriginalExtension();

                // Store the file with the generated name
                $request->file('file')->storeAs(
                    'storageDoc', // Directory where the file will be stored
                    $fileName,    // The unique file name
                    'public'      // The disk to use (in this case, 'public')
                );

                $data['path'] = 'storageDoc/'.$fileName;
            }

            $document->update($data);

            DB::commit();
            return response()->json(['data' => $document]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        try {
            DB::beginTransaction();

            // Delete the file from storage
            if ($document->path) {
                Storage::disk('public')->delete($document->path);
            }

            // Delete related records in document_maintenance_tasks
            DocumentMaintenanceTask::where('document_id', $document->id)->delete();

            // Delete the document
            $document->delete();

            DB::commit();
            return response()->json(['message' => 'Document deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
