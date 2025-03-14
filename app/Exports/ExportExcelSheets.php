<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportExcelSheets implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    private $stock;

    public function __construct($stock)
    {
        $this->stock = $stock;
    }

    public function sheets(): array
    {
        $sheets = [];
        // $activities = Activity::where("name", "WG")->first();

        foreach ($this->stock as $st) {
            $sheets[] = new StockHistoryExport($st['data'], $st['title']);
        }

        return $sheets;
    }
}
