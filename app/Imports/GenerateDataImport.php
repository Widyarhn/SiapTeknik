<?php

namespace App\Imports;

use App\Models\GenerateData;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GenerateDataImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Encode the entire row as JSON
        return new GenerateData([
            'json_data' => json_encode($row),
        ]);
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function rules(): array
    {
        return [
            'json_data' => 'required',
        ];
    }
}
