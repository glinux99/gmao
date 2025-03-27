<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Unity;
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
        // Check if the unity exists
        $unity = Unity ::find($row['unity_id']);
        if (!$unity) {
            // Handle the case where the unity doesn't exist
            // You might want to throw an exception or log an error here
            // For now, we'll just skip this row
            return null;
        }
        return new Category([
            'designation' => $row['designation'],
            'unity_id' => $row['unity_id'],
            'caracteristique' => $row['caracteristique'],
            'avatar' => $row['avatar'], // You might need to handle file uploads differently
            'is_remise' => $row['is_remise'], // Assuming this is a boolean or similar
            'description' => $row['description'],
            'type' => $row['type'],
        ]);
    }

    public function rules(): array
    {
        return [
            'designation' => 'required|string|max:255',
            'unity_id' => [
                'required',
                'integer',
                Rule::exists('unities', 'id'), // Ensure unity_id exists in the unities table
            ],
            'caracteristique' => 'nullable|string',
            'avatar' => 'nullable|string', // Adjust validation based on how you handle avatars
            'is_remise' => 'nullable|boolean', // Adjust validation based on your data type
            'description' => 'nullable|string',
            'type' => 'nullable|string',
        ];
    }
    public function customValidationMessages()
    {
        return [
            'unity_id.exists' => 'The selected unity is invalid.',
        ];
    }
}
