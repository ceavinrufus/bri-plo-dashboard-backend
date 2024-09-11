<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelImport implements ToArray
{
    private $worksheet;

    public function __construct(Worksheet $worksheet)
    {
        $this->worksheet = $worksheet;
    }

    public function array(array $array)
    {
        $filteredData = [];

        foreach ($array as $rowIndex => $row) {
            $rowIndex += 1; // PhpSpreadsheet uses 1-based index

            // Check if the row is visible
            if ($this->worksheet->getRowDimension($rowIndex)->getVisible()) {
                $filteredRow = [];

                foreach ($row as $colIndex => $cellValue) {
                    $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1);

                    // Check if the column is visible
                    if ($this->worksheet->getColumnDimension($columnLetter)->getVisible()) {
                        $filteredRow[] = $cellValue;
                    }
                }

                // Only add row if not empty after filtering columns
                if (!empty($filteredRow)) {
                    $filteredData[] = $filteredRow;
                }
            }
        }

        return $filteredData;
    }
}
