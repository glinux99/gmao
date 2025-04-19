<?php

namespace App\Imports;

use App\Models\Engin;
use App\Models\Team;
use App\Models\Task;
use App\Models\TeamUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportPlanning implements ToCollection, WithHeadingRow, WithMultipleSheets, SkipsEmptyRows
{
    public $sheetNames; // Variable to store sheet names
    public $currentSheetName;

    public function collection(Collection $rows)
    {
        // Process each row to create teams and tasks
        foreach ($rows as $row) {
            // Ensure necessary fields are present
            if (
                !isset($row['equipes']) ||
                !isset($row['techniciens']) ||
                !isset($row['priorite']) ||
                !isset($row['objectif_hebdo']) ||
                !isset($row['vehicules']) ||
                !isset($row['heure_et_lieux_de_depart']) ||
                !isset($row['heure_et_lieux_de_retour'])

            ) {
                continue; // Skip row if essential data is missing
            }


            //Create task
            $dates = $this->extractDatesFromSheetName($this->currentSheetName);

            if ($dates) {
                $startDate = $dates['start']->startOfDay(); // Start of the day
                $dueDate = $dates['end']->endOfDay(); // End of the day

                $startTime = $this->extractTimeFromString($row['heure_et_lieux_de_depart']);
                $endTime = $this->extractTimeFromString($row['heure_et_lieux_de_retour']);

                if (!$startTime) {
                    $startTime = Carbon::parse("07:00:00")->format('H:i:s'); // default 7h

                }
                if (!$endTime) {
                    $endTime = Carbon::parse("16:00:00")->format('H:i:s'); // default 16h
                }
                $startDateTime = Carbon::parse($startDate->toDateString() . " " . $startTime);
                $endDateTime = Carbon::parse($dueDate->toDateString() . " " . $endTime);


            // Extract and process technicians
            $technicianNames = preg_split('/[-,\s]+/', $row['techniciens']); // Split by -, comma, or space
            $chef=0;
            // Find or create the team
            $teamName = $row['equipes'];
            $vehicule = $row['vehicules'] ?? '';

            $authUser = Auth::id();
            if($vehicule!=null){
                $vehicule = Engin::where(DB::raw('lower(name)'), 'like', '%' .strtolower(trim( $vehicule)) . '%')->firstOrCreate(['name'=>$vehicule, 'user_id'=>Auth::id()]);
            }
            $team = Team::create(['name' => $teamName, 'engin_id'=> $vehicule->id ?? null ,  'user_id' => $authUser, 'start_date'=>$startDateTime, 'due_date'=>$endDateTime]);
            // $team->save();
            foreach ($technicianNames as $technicianName) {
                $technicianName = trim($technicianName); // Clean up whitespace
                if (empty($technicianName)) continue;
                $lowerTechnicianName = strtolower($technicianName);
                if (strlen($technicianName) < 3) continue;
                $chef+=1;
                // Check if technician exists by name, post_name, or nickname
                $technician = User::where(function ($query) use ($lowerTechnicianName) {

                    $query->where(DB::raw('lower(name)'), 'like', '%' . $lowerTechnicianName . '%')
                        ->orWhere(DB::raw('lower(post_name)'), 'like', '%' . $lowerTechnicianName . '%')
                        ->orWhere(DB::raw('lower(nickname)'), 'like', '%' . $lowerTechnicianName . '%');
                })->first();
                if(!$technician){
                    $technician = new User();
                    $technician->name = $technicianName;
                    $technician->save();
                }

                $technician->syncRoles('technicien');

                if ($technician) {
                    if($chef==1){
                        Team::find($team->id)->update(['user_id'=> $technician->id, 'name'=> "Equipe de ".$teamName."-".$technicianName." (".$this->currentSheetName. ")"]);
                    }
                    // Attach technician to team if not already attached
                    if (!$team->users()->where('user_id', $technician->id)->exists()) {
                       TeamUser::create(['team_id' => $team->id, 'user_id' => $technician->id]);
                    }
                }
            }

                // dd($endDateTime);
                $taskData = [
                    'description' => $row['priorite'],
                    'status' => "pending",
                    'priority_id' => $this->getPriorityIdFromPriorityString($row['priorite']),
                    'type' => "Planned", // Set the type as 'Plannification'
                    'start_date' => $startDateTime,
                    'due_date' => $endDateTime,
                    'assigned_team_id' => $team->id,
                    'owner' => Auth::id(),
                    'objectif_hebdo' => $row['objectif_hebdo'],
                ];
               $double= Task::where('assigned_team_id',$team->id)
                ->where('start_date',$startDateTime )
                ->where('due_date', $endDateTime)
                ->where('type', "planned")
                ->where('owner',  Auth::id())->first();
                    if(!$double){
                        Task::firstOrCreate($taskData);
                    }

            }
        }

    }

    public function sheets(): array
    {
        // get the file path
        $filePath = request()->file('file')->getRealPath();

        try {
            // Load the spreadsheet
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);

            // Get an array of sheet names
            $sheetNames = $spreadsheet->getSheetNames();

            $sheets = [];
            foreach ($sheetNames as $sheetName) {
                // You can either use the sheet name directly as the key
                $sheets[$sheetName] = new ImportPlanning($sheetName);
                // Or if you need the sheet name to be accessible within the ImportPlanning object
                // and the key to be something else (e.g., an index), you would adjust accordingly.
            }
            return $sheets;

        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            // Handle file reading errors
            dd("Error loading spreadsheet: " . $e->getMessage());
            return []; // Or throw an exception
        } catch (\Exception $e) {
            // Handle other potential errors
            dd("An unexpected error occurred: " . $e->getMessage());
            return []; // Or throw an exception
        }
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function prepareForValidation($data)
    {
    }

    public function __construct($sheetName = null)
    {
        $this->currentSheetName = $sheetName;
    }

    public function getPriorityIdFromPriorityString($priorityString)
    {
        // Assuming you have a Priority model, you can look up the ID like this
        // You'll need to adjust this based on your actual data structure
        $priorityString = trim($priorityString);
        $priority = \App\Models\Priority::where('title', 'like', '%' . $priorityString . '%')
            ->orWhere('title', 'like', "%Dépannage des clients%")
            ->first();

        return $priority ? $priority->id : 2;
    }

    protected function extractDatesFromSheetName($sheetName)
    {
        if (empty($sheetName)) {
            return null;
        }

        // Pattern complet avec tous les cas possibles
        $pattern = '/
            ^Semaine\s+(?:du|DU)\s+          # Début du motif
            (\d{2})                          # Jour de début (groupe 1)
            (?:\s+(\d{2}))?                  # Mois de début optionnel (groupe 2)
            \s+(?:au|AU)\s+                  # Séparateur
            (\d{2})\s+(\d{2})               # Jour et mois de fin (groupes 3-4)
            (?:\s+(\d{4}))?                 # Année optionnelle (groupe 5)
        $/ix';

        if (preg_match($pattern, $sheetName, $matches)) {
            try {
                // Nettoyage des matches
                $matches = array_map('trim', $matches);

                // Extraction des composants
                $startDay = $matches[1];
                $startMonth = !empty($matches[2]) ? $matches[2] : $matches[4]; // Si mois omis, on prend le mois de fin
                $endDay = $matches[3];
                $endMonth = $matches[4];
                $year = !empty($matches[5]) ? $matches[5] : Carbon::now()->year;

                // Validation des mois (1-12)
                if ($startMonth < 1 || $startMonth > 12 || $endMonth < 1 || $endMonth > 12) {
                    return null;
                }

                // Création des dates
                $startDate = Carbon::createFromFormat('d m Y', "$startDay $startMonth $year");
                $endDate = Carbon::createFromFormat('d m Y', "$endDay $endMonth $year");

                // Validation des dates
                if (!$startDate || !$endDate) {
                    return null;
                }

                // Correction si la semaine traverse une nouvelle année
                if ($startDate > $endDate) {
                    $startDate->subYear();
                }

                return [
                    'start' => $startDate->startOfDay(),
                    'end' => $endDate->endOfDay(),
                ];
            } catch (\Exception $e) {
                return null;
            }
        }

        return null;
    }
    protected function extractTimeFromString($timeString)
    {
        // Pattern to match time in HH:MM or HHhMM or HH or HHh format
        $pattern = '/(\d{1,2})[h:]{0,1}(\d{2})?/';

        if (preg_match($pattern, $timeString, $matches)) {

            $hours = intval($matches[1]);
            $minutes = isset($matches[2]) ? intval($matches[2]) : 0;


            // Validate hours and minutes
            if ($hours >= 0 && $hours <= 23 && $minutes >= 0 && $minutes <= 59) {

                return sprintf('%02d:%02d:00', $hours-3, $minutes);
            }
        }

        return null;
    }
}
