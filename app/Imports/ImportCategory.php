<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Unity;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class ImportCategory implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Find the Unity by its designation (name)
        $unity = Unity::where(DB::raw('lower(designation)'), 'like', '%' . strtolower(trim($row['unite'])) . '%')->first();
        if($unity == null){
            $unity=Unity::create(['designation' =>  $row['unite'], 'abbreviation'=> $row['unite'][0]?? '']);
        }
        // If the Unity doesn't exist, set unity_id to null
        $unityId = $unity ? $unity->id : null;
       $catEx= Category::where(DB::raw('lower(designation)'), 'like', '%' . strtolower(trim($row['designation'])) . '%')
        ->where(DB::raw('lower(caracteristique)'), 'like', '%' . strtolower(trim($row['caracteristique'])) . '%')
       ->first();
       if($catEx) {
        return null;
       }
       else{
        return new Category([
            'designation' => $row['designation'],
            'unity_id' => $unityId  ?? null, // Use the ID or null
            'caracteristique' => $row['caracteristique']  ?? null,
            'is_remise' => $row['is_remise'] === 'Oui' ? true : false, // Convert "Oui" to true, otherwise false
            'type' => $row['type'] ?? null,
            // 'avatar' => $row['avatar'], // Removed because it's not in the header
            // 'description' => $row['description'], // Removed because it's not in the header
        ]);
       }
        // Create a new Category instance

    }

    public function rules(): array
    {
        return [
            'designation' => 'required|string|max:255',
            'unite' => 'nullable|string', // Validate that the 'Unité' exists in the unities table by designation
            'caracteristique' => 'nullable|string',
            'is_remise' => 'nullable|in:1,0', // Validate that is_remise is either "Oui" or "Non"
            'type' => 'nullable|string',
            // 'avatar' => 'nullable|string', // Removed because it's not in the header
            // 'description' => 'nullable|string', // Removed because it's not in the header
        ];
    }

    public function customValidationMessages()
    {
        return [
            'unite.exists' => 'The selected unity is invalid.',
            'is_remise.in' => 'The is_remise field must be either "Oui" or "Non".',
        ];
    }
}
