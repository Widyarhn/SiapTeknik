<?php

namespace App\Imports;

use App\Models\LabelImport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class TabelSatuBagianSatu implements WithMappedCells, ToCollection, WithCalculatedFormulas
{
    public function mapping(): array
    {
        $labelImports = LabelImport::where('sheet_name', '1-1')->get();

        $structuredData = [];

        foreach ($labelImports as $labelImport) {
            if (!empty($labelImport->label) && !empty($labelImport->cell)) {
                $structuredData[$labelImport->label] = $labelImport->cell;
            }
        }
        return $structuredData;
    }

    // public function model(array $row)
    // {
    //     $structuredArray = [];

    //     foreach ($row as $label => $nilai) {
    //         $structuredArray[] = [
    //             'label' => $label,
    //             'nilai' => $nilai,
    //         ];
    //     }
        
    //     dd($structuredArray);
    //     return LabelImport::where('label')([
    //         'name' => $row['name'],
    //         'email' => $row['email'],
    //     ]);
    // }

    public function collection(Collection $rows)
    {
        
        foreach ($rows as $label=> $nilai) 
        {
            LabelImport::where('label', $label)->update([
                'nilai' => $nilai,
            ]);
        }
    }
}
