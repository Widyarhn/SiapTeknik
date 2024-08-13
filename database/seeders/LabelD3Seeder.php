<?php

namespace Database\Seeders;

use App\Models\LabelImport;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class LabelD3Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $labels = [
            [
                "label" => "N1",
                "sheet_name" => "1-1",
                "cell"=> "Q13"
            ],[
                "label" => "N2",
                "sheet_name" => "1-2",
                "cell"=> "Q14"
            ],
            [
                "label" => "N3",
                "sheet_name" => "1-3",
                "cell"=> "Q14"
            ],
            [
                "label" => "NI1",
                "sheet_name" => "1-1",
                "cell"=> "Q16"
            ],[
                "label" => "NI2",
                "sheet_name" => "1-2",
                "cell"=> "Q17"
            ],[
                "label" => "NI3",
                "sheet_name" => "1-3",
                "cell"=> "Q17"
            ],[
                "label" => "NN1",
                "sheet_name" => "1-1",
                "cell"=> "Q19"
            ],[
                "label" => "NN2",
                "sheet_name" => "1-2",
                "cell"=> "Q20"
            ],[
                "label" => "NN3",
                "sheet_name" => "1-3",
                "cell"=> "Q20"
            ],[
                "label" => "NW1",
                "sheet_name" => "1-1",
                "cell"=> "Q22"
            ],[
                "label" => "NW2",
                "sheet_name" => "1-2",
                "cell"=> "Q23"
            ],[
                "label" => "NW3",
                "sheet_name" => "1-3",
                "cell"=> "Q23"
            ],

            [
                "label" => "NM",
                "sheet_name" => "2a1",
                "cell"=> "G12"
            ],

            [
                "label" => "NPendaftar",
                "sheet_name" => "2a2",
                "cell"=> "C11"
            ],[
                "label" => "NLolos",
                "sheet_name" => "2a2",
                "cell"=> "D11"
            ],

            [
                "label" => "NDT",
                "sheet_name" => "3a1",
                "cell"=> "Q16"
            ],[
                "label" => "NDTPS",
                "sheet_name" => "3a1",
                "cell"=> "Q17"
            ],[
                "label" => "NDS3",
                "sheet_name" => "3a1",
                "cell"=> "Q18"
            ],[
                "label" => "NDS3",
                "sheet_name" => "3a1",
                "cell"=> "Q18"
            ],[
                "label" => "NDSK",
                "sheet_name" => "3a1",
                "cell"=> "Q19"
            ],[
                "label" => "NDGB",
                "sheet_name" => "3a1",
                "cell"=> "S16"
            ],[
                "label" => "NDLK",
                "sheet_name" => "3a1",
                "cell"=> "S17"
            ],[
                "label" => "NDL",
                "sheet_name" => "3a1",
                "cell"=> "S18"
            ],

            [
                "label" => "RDPU",
                "sheet_name" => "3a2",
                "cell"=> "Q10"
            ],

            [
                "label" => "EWMP",
                "sheet_name" => "3a3",
                "cell"=> "N13"
            ],

            [
                "label" => "NDTT",
                "sheet_name" => "3a4",
                "cell"=> "O14"
            ],

            [
                "label" => "MKK",
                "sheet_name" => "3a5",
                "cell"=> "M8"
            ],[
                "label" => "MKKI",
                "sheet_name" => "3a5",
                "cell"=> "M9"
            ],

            [
                "label" => "NRD",
                "sheet_name" => "3b1",
                "cell"=> "L12"
            ],

            [
                "label" => "RIni",
                "sheet_name" => "3b2",
                "cell"=> "F11"
            ],[
                "label" => "RNnn",
                "sheet_name" => "3b2",
                "cell"=> "F10"
            ],[
                "label" => "RLnl",
                "sheet_name" => "3b2",
                "cell"=> "F9"
            ],

            [
                "label" => "RIni",
                "sheet_name" => "3b3",
                "cell"=> "F12"
            ],[
                "label" => "RNnn",
                "sheet_name" => "3b3",
                "cell"=> "F11"
            ],[
                "label" => "RLnl",
                "sheet_name" => "3b3",
                "cell"=> "F10"
            ],

            [
                "label" => "NA1",
                "sheet_name" => "3b5",
                "cell"=> "N7"
            ],[
                "label" => "NA2",
                "sheet_name" => "3b5",
                "cell"=> "N8"
            ],[
                "label" => "NA3",
                "sheet_name" => "3b5",
                "cell"=> "N9"
            ],[
                "label" => "NA4",
                "sheet_name" => "3b5",
                "cell"=> "N10"
            ],[
                "label" => "NB1",
                "sheet_name" => "3b5",
                "cell"=> "N11"
            ],[
                "label" => "NB2",
                "sheet_name" => "3b5",
                "cell"=> "N12"
            ],[
                "label" => "NB3",
                "sheet_name" => "3b5",
                "cell"=> "N13"
            ],[
                "label" => "NC1",
                "sheet_name" => "3b5",
                "cell"=> "N14"
            ],[
                "label" => "NC2",
                "sheet_name" => "3b5",
                "cell"=> "N15"
            ],[
                "label" => "NC3",
                "sheet_name" => "3b5",
                "cell"=> "N16"
            ],

            [
                "label" => "NAPJ",
                "sheet_name" => "3b7",
                "cell"=> "K7"
            ],

            [
                "label" => "NA",
                "sheet_name" => "3b8-1",
                "cell"=> "J8"
            ],[
                "label" => "NB",
                "sheet_name" => "3b8-2",
                "cell"=> "K8"
            ],[
                "label" => "NC",
                "sheet_name" => "3b8-3",
                "cell"=> "L17"
            ],[
                "label" => "ND",
                "sheet_name" => "3b8-4",
                "cell"=> "K8"
            ],

            [
                "label" => "DOP",
                "sheet_name" => "4a",
                "cell"=> "F12"
            ],[
                "label" => "DPD",
                "sheet_name" => "4a",
                "cell"=> "F13"
            ],[
                "label" => "DPkMD",
                "sheet_name" => "4a",
                "cell"=> "F14"
            ],

            [
                "label" => "JP",
                "sheet_name" => "5a-1",
                "cell"=> "V17"
            ],[
                "label" => "JB",
                "sheet_name" => "5a-1",
                "cell"=> "V18"
            ],

            [
                "label" => "ai",
                "sheet_name" => "5d",
                "cell"=> "C11"
            ],[
                "label" => "bi",
                "sheet_name" => "5d",
                "cell"=> "D11"
            ],[
                "label" => "ci",
                "sheet_name" => "5d",
                "cell"=> "E11"
            ],[
                "label" => "di",
                "sheet_name" => "5d",
                "cell"=> "F11"
            ],

            [
                "label" => "NPkMM",
                "sheet_name" => "7",
                "cell"=> "I7"
            ],[
                "label" => "NPkMD",
                "sheet_name" => "7",
                "cell"=> null
            ],

            [
                "label" => "IPKs-2",
                "sheet_name" => "8a",
                "cell"=> "E6"
            ],[
                "label" => "IPKs-1",
                "sheet_name" => "8a",
                "cell"=> "E7"
            ],[
                "label" => "IPKs",
                "sheet_name" => "8a",
                "cell"=> "E8"
            ],

            [
                "label" => "8b1-NI",
                "sheet_name" => "8b1",
                "cell"=> "N11"
            ],[
                "label" => "8b1-NN",
                "sheet_name" => "8b1",
                "cell"=> "N12"
            ],[
                "label" => "8b1-NW",
                "sheet_name" => "8b1",
                "cell"=> "N13"
            ],

            [
                "label" => "8b2-NI",
                "sheet_name" => "8b2",
                "cell"=> "N12"
            ],[
                "label" => "8b2-NN",
                "sheet_name" => "8b2",
                "cell"=> "N13"
            ],[
                "label" => "8b2-NW",
                "sheet_name" => "8b2",
                "cell"=> "N14"
            ],

            [
                "label" => "8b1-NI",
                "sheet_name" => "8b1",
                "cell"=> "N11"
            ],[
                "label" => "8b1-NN",
                "sheet_name" => "8b1",
                "cell"=> "N12"
            ],[
                "label" => "8b1-NW",
                "sheet_name" => "8b1",
                "cell"=> "N13"
            ],

            [
                "label" => "NL",
                "sheet_name" => "8d1",
                "cell"=> "B27"
            ],[
                "label" => "NJ",
                "sheet_name" => "8d1",
                "cell"=> "C27"
            ],[
                "label" => "N-WT3",
                "sheet_name" => "8d1",
                "cell"=> "E27"
            ],[
                "label" => "N-WT36",
                "sheet_name" => "8d1",
                "cell"=> "F27"
            ],[
                "label" => "N-WT6",
                "sheet_name" => "8d1",
                "cell"=> "G27"
            ],

            [
                "label" => "8e2-ai1",
                "sheet_name" => "8e2",
                "cell"=> "C7"
            ],[
                "label" => "8e2-bi1",
                "sheet_name" => "8e2",
                "cell"=> "D7"
            ],[
                "label" => "8e2-ci1",
                "sheet_name" => "8e2",
                "cell"=> "E7"
            ],[
                "label" => "8e2-di1",
                "sheet_name" => "8e2",
                "cell"=> "F7"
            ],[
                "label" => "8e2-ai2",
                "sheet_name" => "8e2",
                "cell"=> "C8"
            ],[
                "label" => "8e2-bi2",
                "sheet_name" => "8e2",
                "cell"=> "D8"
            ],[
                "label" => "8e2-ci2",
                "sheet_name" => "8e2",
                "cell"=> "E8"
            ],[
                "label" => "8e2-di2",
                "sheet_name" => "8e2",
                "cell"=> "F8"
            ],[
                "label" => "8e2-ai3",
                "sheet_name" => "8e2",
                "cell"=> "C9"
            ],[
                "label" => "8e2-bi3",
                "sheet_name" => "8e2",
                "cell"=> "D9"
            ],[
                "label" => "8e2-ci3",
                "sheet_name" => "8e2",
                "cell"=> "E9"
            ],[
                "label" => "8e2-di3",
                "sheet_name" => "8e2",
                "cell"=> "F9"
            ],[
                "label" => "8e2-ai4",
                "sheet_name" => "8e2",
                "cell"=> "C10"
            ],[
                "label" => "8e2-bi4",
                "sheet_name" => "8e2",
                "cell"=> "D10"
            ],[
                "label" => "8e2-ci4",
                "sheet_name" => "8e2",
                "cell"=> "E10"
            ],[
                "label" => "8e2-di4",
                "sheet_name" => "8e2",
                "cell"=> "F10"
            ],[
                "label" => "8e2-ai5",
                "sheet_name" => "8e2",
                "cell"=> "C11"
            ],[
                "label" => "8e2-bi5",
                "sheet_name" => "8e2",
                "cell"=> "D11"
            ],[
                "label" => "8e2-ci5",
                "sheet_name" => "8e2",
                "cell"=> "E11"
            ],[
                "label" => "8e2-di5",
                "sheet_name" => "8e2",
                "cell"=> "F11"
            ],[
                "label" => "8e2-ai6",
                "sheet_name" => "8e2",
                "cell"=> "C12"
            ],[
                "label" => "8e2-bi6",
                "sheet_name" => "8e2",
                "cell"=> "D12"
            ],[
                "label" => "8e2-ci6",
                "sheet_name" => "8e2",
                "cell"=> "E12"
            ],[
                "label" => "8e2-di6",
                "sheet_name" => "8e2",
                "cell"=> "F12"
            ],[
                "label" => "8e2-ai7",
                "sheet_name" => "8e2",
                "cell"=> "C13"
            ],[
                "label" => "8e2-bi7",
                "sheet_name" => "8e2",
                "cell"=> "D13"
            ],[
                "label" => "8e2-ci7",
                "sheet_name" => "8e2",
                "cell"=> "E13"
            ],[
                "label" => "8e2-di7",
                "sheet_name" => "8e2",
                "cell"=> "F13"
            ],

            [
                "label" => "8f4-NAPJ",
                "sheet_name" => "8f4",
                "cell"=> "F13"
            ],
        ];
    
        foreach(ProgramStudi::where('jenjang_id', 1)->get() as $key => $prodi)
            foreach($labels as $item)
                LabelImport::insert([
                    'program_studi_id' => $prodi->id,
                    "label" => $item["label"],
                    "sheet_name" => $item["sheet_name"],
                    "cell"=> $item["cell"],
                ]);
    }
}
