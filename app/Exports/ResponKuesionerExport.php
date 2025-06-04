<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class ResponKuesionerExport implements FromArray
{
    protected $rows;
    public function __construct(array $rows)
    {
        $this->rows = $rows;
    }
    public function array(): array
    {
        if (empty($this->rows)) return [];
        // Buat header dari semua key unik
        $header = array_unique(array_merge(...array_map('array_keys', $this->rows)));
        $data = [$header];
        foreach ($this->rows as $row) {
            $data[] = array_map(function($h) use ($row) {
                return $row[$h] ?? '';
            }, $header);
        }
        return $data;
    }
}
