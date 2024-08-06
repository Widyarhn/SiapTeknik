<?php

namespace App\Imports;

use App\Models\ImportLkps;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CustomImportLkps
{
    public function import($file, $id_prodi, $id_kriteria)
    {
        // dd($file);
        try {
            $spreadSheet = IOFactory::load($file);
            $sheetNames = $spreadSheet->getSheetNames();

            foreach ($sheetNames as $sheetIndex => $sheetName) {
                $sheet = $spreadSheet->getSheet($sheetIndex);
                $rows = $sheet->toArray();
                // dd($rows);

                if (count($rows) > 0) {
                    // $header = array_shift($rows);
                    // dd($header);

                    $nonEmptyRows = array_filter($rows, function($row) {
                        return array_filter($row, function($value) {
                            return !empty(trim($value));
                        });
                    });

                    $filteredRows = array_map(function($row) {
                        // Filter kolom dengan index di atas 22
                        $filteredRow = array_filter(
                            array_slice($row, 22), // Ambil kolom dari index 22 ke atas
                            function($value) {
                                return !empty(trim($value));
                            }
                        );
                        // Kembalikan baris lengkap dengan kolom yang tidak diubah
                        return array_merge(array_slice($row, 0, 22), $filteredRow);
                    }, $nonEmptyRows);
            
                    // Reindex array jika diperlukan
                    $filteredRows = array_values($filteredRows);

                    // Ambil header dari baris pertama
                    $headers = array_shift($filteredRows);

                    $data = array_map(function($row) use ($headers) {
                        $key = array_shift($row); // Ambil nilai pertama sebagai key
                        return array_combine($headers, array_merge([$key], $row)); // Gabungkan header dengan nilai lainnya
                    }, $filteredRows);

                    // Format JSON
                    $json = json_encode(['data' => $data], JSON_PRETTY_PRINT);

                    // dd($json);

                    // foreach ($nonEmptyRows as $row) {
                    //     $rowData = array_combine($header, $row);

                    //     ImportLkps::create([
                    //         'kriteria_id' => $id_kriteria,
                    //         'program_studi_id' => $id_prodi,
                    //         'sheet_name' => $sheetName,
                    //         'json' => json_encode($rowData),
                    //     ]);
                    // }

                    ImportLkps::create([
                                'kriteria_id' => $id_kriteria,
                                'program_studi_id' => $id_prodi,
                                'sheet_name' => $sheetName,
                                'json' => $json,
                            ]);
                }
            }
        
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
        
}
