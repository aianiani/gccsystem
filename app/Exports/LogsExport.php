<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LogsExport implements WithMultipleSheets
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        $sheets = [];
        foreach ($this->data as $type => $collection) {
            $sheets[] = new SingleLogSheetExport($type, $collection);
        }
        return $sheets;
    }
}

// Helper class for each sheet
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class SingleLogSheetExport implements FromCollection, WithTitle
{
    protected $type;
    protected $collection;

    public function __construct($type, $collection)
    {
        $this->type = ucfirst($type);
        $this->collection = $collection;
    }

    public function collection()
    {
        return $this->collection;
    }

    public function title(): string
    {
        return $this->type;
    }
} 