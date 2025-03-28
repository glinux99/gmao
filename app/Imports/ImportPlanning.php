<?php

namespace App\Imports;

use App\Models\Team;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ImportPlanning implements ToCollection, WithHeadingRow, WithMultipleSheets, SkipsEmptyRows
{
    public function collection(Collection $rows)
    {
        // Process each row to create teams and tasks
        foreach ($rows as $row) {
            // Ensure necessary fields are present
            if (
                !isset($row['equipes']) ||
                !isset($row['techniciens']) ||
                !isset($row['priorite']) ||
                !isset($row['objectif_hebdo'])||
                 !isset($row['heure_et_lieux_de_depart'])||
                !isset($row['heure_et_lieux_de_retour'])

            ) {
                continue; // Skip row if essential data is missing
            }

            // Find or create the team
            $teamName = $row['equipes'];
            $team = Team::firstOrCreate(['name' => $teamName]);
            $team->save();

            // Extract and process technicians
            $technicianNames = preg_split('/[-,\s]+/', $row['techniciens']); // Split by -, comma, or space
            foreach ($technicianNames as $technicianName) {
                $technicianName = trim($technicianName); // Clean up whitespace
                if (empty($technicianName)) continue;

                // Check if technician exists by name, post_name, or nickname
                $technician = User::where(function ($query) use ($technicianName) {
                    $query->where('name', 'like', '%' . $technicianName . '%')
                        ->orWhere('post_name', 'like', '%' . $technicianName . '%')
                        ->orWhere('nickname', 'like', '%' . $technicianName . '%');
                })->first();

                if ($technician) {
                    // Attach technician to team if not already attached
                    if (!$team->users()->where('user_id', $technician->id)->exists()) {
                        $team->users()->attach($technician->id);
                    }
                }
            }

            //Create task
            $dateInterval = $this->currentSheetName;
            $dates = explode(' - ', $dateInterval);

             if (count($dates) === 2) {
                $startDate = Carbon::parse($dates[0])->startOfDay(); // Start of the day
                $dueDate = Carbon::parse($dates[1])->endOfDay(); // End of the day

                $startTime = Carbon::parse($row['heure_et_lieux_de_depart'])->format('H:i:s');
                $endTime = Carbon::parse($row['heure_et_lieux_de_retour'])->format('H:i:s');
                $startDateTime = Carbon::parse($startDate->toDateString()." ". $startTime);
                $endDateTime = Carbon::parse($dueDate->toDateString()." ". $endTime);
                // dd($endDateTime);
                 $taskData = [
                   'description'=>$row['priorite'],
                   'status'=>"pending",
                   'priority_id'=>$this->getPriorityIdFromPriorityString($row['priorite']),
                    'type' => "Plannification", // Set the type as 'Plannification'
                    'start_date' => $startDateTime->format('Y-m-d H:i:s'),
                    'due_date' => $endDateTime->format('Y-m-d H:i:s'),
                    'assigned_team_id' => $team->id,
                    'owner'=>User::role('admin')->first()->id,
                    'objectif_hebdo'=>$row['objectif_hebdo'],
                ];
                 Task::create($taskData);

            }
        }

    }

    public function sheets(): array
    {
        return [
            // You can add more sheets here if needed, or just let it handle all sheets
            $this,
        ];
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function prepareForValidation($data)
    {
    }
    public $currentSheetName;
    public function __construct($sheetName=null)
    {
        $this->currentSheetName = $sheetName;
    }
     public function getPriorityIdFromPriorityString($priorityString){
        // Assuming you have a Priority model, you can look up the ID like this
        // You'll need to adjust this based on your actual data structure
        $priorityString = trim($priorityString);
        $priority = \App\Models\Priority::where('title', 'like', '%' . $priorityString . '%')
            ->orWhere('title','like',"%Dépannage des clients%")
            ->first();

        return $priority ? $priority->id : 2;
    }
}
