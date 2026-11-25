<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Export;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SalesReportExport implements Export, WithMultipleSheets
{
    public function __construct(protected $start, protected $end, protected $userId = null)
    {
    }

    public function sheets(): array
    {
        return [
            new SalesExport($this->start, $this->end, $this->userId),
            new TopProductsExport($this->start, $this->end, $this->userId),
        ];
    }
}