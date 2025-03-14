<?php

namespace App\Exports;

use App\Models\StockHistory;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithTitle;

class StockHistoryExport implements  FromQuery,WithMapping,WithHeadings, WithTitle
{
    use Exportable;

    private $stock;
    public $title;

    public function __construct($stock,$title)
    {
        $this->stock = $stock;
        $this->title = $title;
    }

    public function properties(): array
    {
        return [
            'creator' => 'Daniel',
            'lastModifiedBy' => 'Daniel',
            'title' => 'Invoices Export',
            'description' => 'Repport',
            'subject' => 'Repport',
            'keywords' => 'invoices,export,spreadsheet',
            'category' => 'Repport',
            'manager' => 'VE',
            'company' => 'Virunga Energies',
        ];
    }

    public function map($stock):array
    {
        return [
           $stock->id,
           $stock->demandeur['name'] ?? "System",
            $stock->reference ?? "Sous station",
            $stock->etat,
            $stock->category->designation,
            $stock->quantity,
            $stock->type=="withdraw"? "Materiel Sortie": "Materiel Entre",
           $stock->quantity_restante,
            $stock->created_at->format('Y-m-d H:i:s'),
           $stock->updated_at->format('Y-m-d H:i:s'),
        ];
    }
    public function query()
    {
        return $this->stock->orderByDesc('id');
    }
    public function headings(): array
    {
        return [
            '#',
            'Demandeur',
            'Reference',
            'Etat',
            'Categorie',
            'Quantite',
            'type',
            'Quantite restante',
            'Date de demande',
            'Date de mis a jour',
        ];
    }
    public function title(): string
    {
        return $this->title;
    }
}

