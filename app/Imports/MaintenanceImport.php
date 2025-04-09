<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Maintenance;
use App\Models\Depense;
use App\Models\Task;
use App\Models\User;
use App\Models\Instruction;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithValidation;

class MaintenanceImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    protected $totalTechnicianCost = 0;
    protected $totalLaborerCost = 0;
    protected $maintenance;

    public function model(array $row)
    {
        // DB::beginTransaction();
        // try {
            // Ensure necessary fields are present
            if (
                !isset($row['techniciens']) ||
                !isset($row['nbre_tacherons']) ||
                !isset($row['taches']) ||
                !isset($row['zone']) ||
                !isset($row['moyen_de_transport']) ||
                !isset($row['heure_de_depart']) ||
                !isset($row['heure_de_fin_des_travaux_sur_le_reseau']) ||
                !isset($row['duree_estimative_des_activites']) ||
                !isset($row['duree_realisee']) ||
                !isset($row['materiels_utilises']) ||
                !isset($row['homme_heure_technicien']) ||
                !isset($row['homme_heure_tt'])
            ) {
                Log::warning('Skipping row due to missing data: ', $row);
                return null; // Skip row if essential data is missing
            }

            // Create Maintenance (only once)
            if (!$this->maintenance) {
                $this->maintenance = Maintenance::create([
                    'work_order' => "Maintenance",
                    'nbre_tacherons' => 0,
                    'frequency' => "unique",
                    'type' => "Maintenance",
                    'materiels' => "",
                    'man_hours' => 0,
                    'maintenance_cost' => 0,
                    'start_date' => $this->parseTimeString($row['heure_de_depart']),
                    'end_date' => $this->parseTimeString($row['heure_de_fin_des_travaux_sur_le_reseau']),
                    'description' => "Maintenance",
                    'status' => 'pending',
                    'user_id' => Auth::id(),
                ]);
            }

            // Extract and process technicians
            $technicianNames = preg_split('/[,]+/', $row['techniciens']); // Split by comma
            $technicians = [];
            $teamLeader = null; // Initialize team leader
            foreach ($technicianNames as $index => $technicianName) {
                $technicianName = trim($technicianName); // Clean up whitespace
                if (empty($technicianName)) continue;
                $lowerTechnicianName = strtolower($technicianName);
                if (strlen($technicianName) < 3) continue;
                // Check if technician exists by name, post_name, or nickname
                $technician = User::where(function ($query) use ($lowerTechnicianName) {
                    $query->where(DB::raw('lower(name)'), 'like', '%' . $lowerTechnicianName . '%')
                        ->orWhere(DB::raw('lower(post_name)'), 'like', '%' . $lowerTechnicianName . '%')
                        ->orWhere(DB::raw('lower(nickname)'), 'like', '%' . $lowerTechnicianName . '%');
                })->first();
                if (!$technician) {
                    $technician = new User();
                    $technician->name = $technicianName;
                    $technician->password = Hash::make('12345678');
                    $technician->save();
                }
                $technician->syncRoles('technicien');
                $technicians[] = $technician->id;
                if ($index === 0) {
                    $teamLeader = $technician->id; // Set the first technician as the team leader
                }
            }

            $nbreTechniciens = count($technicians);

            // Clean and calculate technician cost
            $hommeHeureTechnicien = str_replace('$', '', $row['homme_heure_technicien']);
            $technicianCost = $nbreTechniciens * floatval($hommeHeureTechnicien);

            // Clean and calculate laborer cost
            $hommeHeureTt = str_replace('$', '', $row['homme_heure_tt']);
            $laborerCost = intval($row['nbre_tacherons']) * floatval($hommeHeureTt);

            // Accumulate costs
            $this->totalTechnicianCost += $technicianCost;
            $this->totalLaborerCost += $laborerCost;

            // Assign technicians to maintenance


            // Handle instructions for the task
                        // Handle instructions for the task
                        $taskDescription = Str::limit($row['taches'], 255);
                        // Create Task
                        $task = Task::create([
                            'description' => "Maintenance : " . $taskDescription . " pour l'équipe de " . User::find($teamLeader)->name, // Set task description
                            'status' => 'pending',
                            'type' => 'Maintenance',
                            'start_date' => $this->parseTimeString($row['heure_de_depart']),
                            'due_date' => $this->parseTimeString($row['heure_de_fin_des_travaux_sur_le_reseau']),
                            'maintenance_id' => $this->maintenance->id,
                            'owner' => Auth::id(),
                        ]);
                        $task->technicians()->attach($technicians);
                        $instructions = preg_split('/[,]+/', $row['taches']);
                        foreach ($instructions as $instructionDescription) {
                            $instructionDescription = trim($instructionDescription);
                            if (empty($instructionDescription)) continue;
                            Instruction::create([
                                'task_id' => $task->id,
                                'description' => $instructionDescription,
                                'response_type' => 'checkbox',
                            ]);
                        }


            // Handle materials for maintenance
            $materials = preg_split('/[,]+/', $row['materiels_utilises']);
            foreach ($materials as $materialName) {
                $materialName = trim($materialName);
                if (empty($materialName)) continue;
                $material = Category::where('designation', 'like', '%' . $materialName . '%')->first();
                if (!$material) {
                    $material = Category::create(['designation' => $materialName]);
                }
                $this->maintenance->materials()->attach($material, ['quantity' => 1]);
            }

            // Create expenses for technicians and laborers
            Depense::create([
                'maintenance_id' => $this->maintenance->id,
                'title' => 'Coût de Techniciens',
                'amount' => $technicianCost,
                // 'readonly' => true,
            ]);

            Depense::create([
                'maintenance_id' => $this->maintenance->id,
                'title' => 'Coût de Tâcherons',
                'amount' => $laborerCost,
                'readonly' => true,
            ]);
            // DB::commit();
            return $this->maintenance;
        // } catch (\Throwable $th) {
        //     DB::rollback();
        //     Log::error('Error importing maintenance data: ' . $th->getMessage(), ['row' => $row]);
        //     // Handle the error, log it, or return an error response
        //     // dd($th->getMessage());
        //     return null;
        // }
    }


    public function rules(): array
    {
        return [
            'techniciens' => 'required|string|max:255',
            'nbre_tacherons' => 'required|numeric',
            'taches' => 'required|string',
            'zone' => 'required|string|max:255',
            // 'moyen_de_transport' => 'required|string|max:255',
            'heure_de_depart' => 'required|string|max:255',
            'heure_de_fin_des_travaux_sur_le_reseau' => 'required|string|max:255',
            'duree_estimative_des_activites' => 'required|string|max:255',
            'duree_realisee' => 'required|string|max:255',
            // 'materiels_utilises' => 'required|string|max:255',
            'homme_heure_technicien' => 'required|numeric',
            'homme_heure_tt' => 'required|numeric',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'techniciens.required' => 'The technicians field is required.',
            'techniciens.string' => 'The technicians field must be a string.',
            'techniciens.max' => 'The technicians field must not exceed 255 characters.',
            'nbre_tacherons.required' => 'The number of laborers field is required.',
            'nbre_tacherons.numeric' => 'The number of laborers must be a number.',
            'taches.required' => 'The tasks field is required.',
            'taches.string' => 'The tasks field must be a string.',
            'taches.max' => 'The tasks field must not exceed 255 characters.',
            'zone.required' => 'The zone field is required.',
            'zone.string' => 'The zone field must be a string.',
            'zone.max' => 'The zone field must not exceed 255 characters.',
            'moyen_de_transport.required' => 'The means of transport field is required.',
            'moyen_de_transport.string' => 'The means of transport field must be a string.',
            'moyen_de_transport.max' => 'The means of transport field must not exceed 255 characters.',
            'heure_de_depart.required' => 'The departure time field is required.',
            'heure_de_depart.string' => 'The departure time field must be a string.',
            'heure_de_depart.max' => 'The departure time field must not exceed 255 characters.',
            'heure_de_fin_des_travaux_sur_le_reseau.required' => 'The work end time field is required.',
            'heure_de_fin_des_travaux_sur_le_reseau.string' => 'The work end time field must be a string.',
            'heure_de_fin_des_travaux_sur_le_reseau.max' => 'The work end time field must not exceed 255 characters.',
            'duree_estimative_des_activites.required' => 'The estimated duration field is required.',
            'duree_estimative_des_activites.string' => 'The estimated duration field must be a string.',
            'duree_estimative_des_activites.max' => 'The estimated duration field must not exceed 255 characters.',
            'duree_realisee.required' => 'The actual duration field is required.',
            'duree_realisee.string' => 'The actual duration field must be a string.',
            'duree_realisee.max' => 'The actual duration field must not exceed 255 characters.',
            'materiels_utilises.required' => 'The materials used field is required.',
            'materiels_utilises.string' => 'The materials used field must be a string.',
            'materiels_utilises.max' => 'The materials used field must not exceed 255 characters.',
            'homme_heure_technicien.required' => 'The technician man-hour rate field is required.',
            'homme_heure_technicien.numeric' => 'The technician man-hour rate must be a number.',
            'homme_heure_tt.required' => 'The laborer man-hour rate field is required.',
            'homme_heure_tt.numeric' => 'The laborer man-hour rate must be a number.',
        ];
    }

    private function parseTimeString($timeString)
    {
        // Remove the 'h' character and any extra whitespace
        $timeString = str_replace('h', ':', $timeString);
        $timeString = trim($timeString);

        // Check if the string contains only digits and colons
        if (!preg_match('/^[\d:]+$/', $timeString)) {
            // Handle invalid time format (e.g., log an error, set a default time, etc.)
            // For now, let's return a default time
            return Carbon::now()->format('Y-m-d H:i:s');
        }
        // Attempt to parse the time string
        try {
            $time = Carbon::createFromFormat('H:i', $timeString);
            // If parsing is successful, format the time and return it
            return $time->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            // Handle parsing errors (e.g., log an error, set a default time, etc.)
            // For now, let's return a default time
            return Carbon::now()->format('Y-m-d H:i:s');
        }
    }
}
