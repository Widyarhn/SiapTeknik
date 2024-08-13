<?php

namespace App\Imports;

use Log;
use App\Models\ImportLkps;
use App\Models\LabelImport;
use App\Models\ProgramStudi;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportLkpsExcel
{
    public function import($file,$id_prodi, $id_kriteria)
    {
        try {
            $programStudi = ProgramStudi::with('jenjang')->find($id_prodi);
            $jenjangName = $programStudi->jenjang->jenjang;

            $spreadsheet = IOFactory::load($file);

            if($jenjangName == "D3"){
                $fileName = $file->getClientOriginalName();
                $filePath = $file->store('dok-import/d3', 'public');
            }else{
                $fileName = $file->getClientOriginalName();
                $filePath = $file->store('dok-import/d4', 'public');
            }
            // dd($spreadsheet);

            $labelImports = LabelImport::all();
            

            $sheetData = $labelImports->groupBy('sheet_name');
            // dd($sheetData);

            foreach ($sheetData as $sheetName => $imports) {
                $worksheet = $spreadsheet->getSheetByName($sheetName);

                if ($worksheet) {
                    foreach ($imports as $labelImport) {
                        $cellAddress = $labelImport->cell;
                        $label = $labelImport->label;

                        $cellValue = $worksheet->getCell($cellAddress)->getCalculatedValue();

                        LabelImport::where('label', $label)->where('program_studi_id',$id_prodi)->update([
                            'nilai' => $cellValue,
                        ]);
                    }
                }
                //  else {
                //     // Jika sheet tidak ditemukan, bisa menambahkan logika lain atau memberi tahu
                //     // Log::warning("Sheet with name '{$sheetName}' not found in the file.");
                // }
            }
            ImportLkps::create([
                'kriteria_id' => $id_kriteria,
                'program_studi_id' => $id_prodi,
                'file' => $filePath,
                'display_name' => $fileName,
            ]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
        
    }
}
