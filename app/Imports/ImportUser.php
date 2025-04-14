<?php

namespace App\Imports;

use App\Models\Region;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Hash;

class ImportUser implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            $region = trim($row['region']); // Clean up whitespace
        $region = strtolower($region);
        $region =Region::where(DB::raw('lower(titre)'), 'like', '%' . $row['region'] . '%')->first();
        if(!$region){
            $region=  Region::create(['titre' => $row['region']]);
        }
        $region_id=$region->id ??null;
        } catch (\Throwable $th) {
            //throw $th;
        }

        // Create a new user instance.
        $user = new User([
            'name' => $row['name'],
            'email' => $row['email']  ?? null,
            //generate default password for the user
            'password' => Hash::make($row['password'] ?? '12345678'),
            'post_name' => $row['post_name'] ?? null,
            'nickname' => $row['nickname'] ?? null,
            'number' => $row['number'] ?? null,
            'pointure' => $row['pointure'] ?? null,
            'category' => $row['category'] ?? null,
            'level' => $row['level'] ?? null,
            'type' => $row['type'] ?? null,
            'function' => $row['function'] ?? null,
            'size' => $row['size'] ?? null,
            'status' => $row['status'] ?? null,
            'address' => $row['address'] ?? null,
            'contrat' => $row['contrat'] ?? null,
            'region_id' => $region_id ?? null,
        ]);

        // Assign the 'technicien' role to the user.
        $user->syncRoles('technicien');

        return $user;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email'=>'nullable|string',
            'password'=>'nullable|string',
            'post_name'=>'nullable|string',
            'nickname'=>'nullable|string',
            'number'=>'nullable|string',
            'pointure'=>'nullable|string',
            'category'=>'nullable|string',
            'level'=>'nullable|string',
            'type'=>'nullable|string',
            'size'=>'nullable|string',
            'status'=>'nullable|string',
            'address'=>'nullable|string',
            'contrat'=>'nullable|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.required' => 'the name is required.',

        ];
    }
}
