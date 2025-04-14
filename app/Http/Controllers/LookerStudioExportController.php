<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LookerStudioExportController extends Controller
{
    public function exportAllTables(Request $request)
    {
        // Get all table names from the SQLite database
        $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
        $tableNames = array_map(function ($table) {
            return $table->name;
        }, $tables);

        $allData = [];

        foreach ($tableNames as $tableName) {
            // Check if the table exists
            if (Schema::hasTable($tableName)) {
                // Fetch all data from the table
                $data = DB::table($tableName)->get()->toArray();

                // Add the data to the allData array with the table name as the key
                $allData[$tableName] = $data;
            }
        }

        // Return the data as JSON
        return response()->json($allData);
    }
}
