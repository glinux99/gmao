<?php

namespace App\Http\Controllers;

use App\Imports\ImportUser;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function import(Request $request)
    {
        // $request->validate([
        //     'file' => 'required|mimes:xlsx,xls',
        // ]);

        try {
            Excel::import(new ImportUser, $request->file('file'));
            return response()->json([
                'message' => 'users imported successfully',
                'success' => true
            ]);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Row " . $failure->row() . ": " . implode(", ", $failure->errors());
            }
            return response()->json([
                'errors' => $errors,
                'message' => 'Validation error ',
                'success' => false
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during import.',
                'errors'=>$e->getMessage(),
                'success' => false
            ]);
        }
    }
}
