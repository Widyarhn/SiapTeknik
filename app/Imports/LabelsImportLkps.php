<?php

namespace App\Imports;

use App\Models\LabelImport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LabelsImportLkps implements WithMultipleSheets
{
    // public function sheets(): array
    // {
    //     return [
    //         '1-1' => new TabelSatuBagianSatu(),
    //         // '1-2' => new TabelSatuBagianDua(),
    //         // '1-3' => new TabelSatuBagianTiga(),
    //         // '3a1' => new TabelTigaASatu(),
    //     ];
    // }
    protected $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function sheets(): array
    {
        return [
            '1-1' => new TabelSatuBagianSatu($this->file),
            // '1-2' => new TabelSatuBagianDua($this->file),
            // '1-3' => new TabelSatuBagianTiga($this->file),
            // '3a1' => new TabelTigaASatu($this->file),
        ];
    }
}
