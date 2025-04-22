<?php

namespace App\Imports;

use App\Models\GoogleMaps;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;

class GoogleMapsImport implements ToModel, WithHeadingRow, WithValidation
{

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $google= new GoogleMaps ([
            'zone' => $row['zone'],
            'code_rm' => $row['code_rm'],
            'client_number' => $row['numero_du_client'],
            'last_name' => $row['nom_de_famille'],
            'first_name' => $row['prenom'],
            'phone' => $row['telephone'],
            'commercial_agent_name' => "",
            'connection_type' => $row['connectitype_de_raccordement_(compteur)on_type'] ?? "",
            'rate' => $row['tarif'],
            'latitude' => $row['coordonnees_gps_lattitude'],
            'longitude' => $row['coordonees_gps_longitude'],
            'installation_type' => $row['installation_avec_ou_sans_ready_box'],
            'days' => $row['jours'] ?? "",
            'payment_date' => $row['date_de_paiement'],
            'need_small_pole' => $row['besoin_d_un_petit_poteau'] ?? "",
            'pole' => $row['poteau'] ?? $row['numero_poteau']  ?? "",
        ]);
        return $google;
    }
    public function rules(): array
    {
        return [
            'zone' => ['nullable', 'string'],
            'code_rm' => ['nullable', 'string'],
            'client_number' => ['nullable', 'string'],
            'last_name' => ['nullable', 'string'],
            'first_name' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'commercial_agent_name' => ['nullable', 'string'],
            'connection_type' => ['nullable', 'string'],
            'rate' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'installation_type' => ['nullable', 'string'],
            'days' => ['nullable', 'integer'],
            'payment_date' => ['nullable', 'date'],
            'need_small_pole' => ['nullable', 'boolean'],
            'pole' => ['nullable', 'integer'],
        ];
    }
}
