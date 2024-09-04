<?php

namespace Database\Seeders;

use App\Models\LabelImport;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class LabelD4Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $labeld4 = [
            [
                "label" => "N1",
                "sheet_name" => "1-1",
                "cell" => "Q13"
            ],
            [
                "label" => "N2",
                "sheet_name" => "1-2",
                "cell" => "Q14"
            ],
            [
                "label" => "N3",
                "sheet_name" => "1-3",
                "cell" => "Q14"
            ],
            [
                "label" => "NI1",
                "sheet_name" => "1-1",
                "cell" => "Q16"
            ],
            [
                "label" => "NI2",
                "sheet_name" => "1-2",
                "cell" => "Q17"
            ],
            [
                "label" => "NI3",
                "sheet_name" => "1-3",
                "cell" => "Q17"
            ],
            [
                "label" => "NN1",
                "sheet_name" => "1-1",
                "cell" => "Q19"
            ],
            [
                "label" => "NN2",
                "sheet_name" => "1-2",
                "cell" => "Q20"
            ],
            [
                "label" => "NN3",
                "sheet_name" => "1-3",
                "cell" => "Q20"
            ],
            [
                "label" => "NW1",
                "sheet_name" => "1-1",
                "cell" => "Q22"
            ],
            [
                "label" => "NW2",
                "sheet_name" => "1-2",
                "cell" => "Q23"
            ],
            [
                "label" => "NW3",
                "sheet_name" => "1-3",
                "cell" => "Q23"
            ],

            [
                "label" => "NM",
                "sheet_name" => "2a1",
                "cell" => "G12"
            ],
            [
                "label" => "NPendaftar",
                "sheet_name" => "2a1",
                "cell" => "C12"
            ],
            [
                "label" => "NLolos",
                "sheet_name" => "2a1",
                "cell" => "D12"
            ],
            // [
            //     "label" => "NM",
            //     "sheet_name" => "2a2",
            //     "cell" => "G11"
            // ],

            [
                "label" => "JM_AKTIF",
                "sheet_name" => "2b",
                "cell" => "N7"
            ],
            [
                "label" => "JM_ASING_FT",
                "sheet_name" => "2b",
                "cell" => "N10"
            ],
            [
                "label" => "JM_ASING_PT",
                "sheet_name" => "2b",
                "cell" => "N13"
            ],

            [
                "label" => "NDT",
                "sheet_name" => "3a1",
                "cell" => "Q16"
            ],
            [
                "label" => "NDTPS",
                "sheet_name" => "3a1",
                "cell" => "Q17"
            ],
            [
                "label" => "NDS3",
                "sheet_name" => "3a1",
                "cell" => "Q18"
            ],
            [
                "label" => "NDSK",
                "sheet_name" => "3a1",
                "cell" => "Q19"
            ],
            [
                "label" => "NDGB",
                "sheet_name" => "3a1",
                "cell" => "S16"
            ],
            [
                "label" => "NDLK",
                "sheet_name" => "3a1",
                "cell" => "S17"
            ],
            [
                "label" => "NDL",
                "sheet_name" => "3a1",
                "cell" => "S18"
            ],

            [
                "label" => "RDPU",
                "sheet_name" => "3a2",
                "cell" => "Q10"
            ],

            [
                "label" => "EWMP",
                "sheet_name" => "3a3",
                "cell" => "N13"
            ],

            [
                "label" => "NDTT",
                "sheet_name" => "3a4",
                "cell" => "O14"
            ],

            [
                "label" => "MKK",
                "sheet_name" => "3a5",
                "cell" => "M8"
            ],
            [
                "label" => "MKKI",
                "sheet_name" => "3a5",
                "cell" => "M9"
            ],

            [
                "label" => "NRD",
                "sheet_name" => "3b1",
                "cell" => "L12"
            ],

            [
                "label" => "NI",
                "sheet_name" => "3b2",
                "cell" => "F11"
            ],
            [
                "label" => "NN",
                "sheet_name" => "3b2",
                "cell" => "F10"
            ],
            [
                "label" => "NL",
                "sheet_name" => "3b2",
                "cell" => "F9"
            ],

            [
                "label" => "NI",
                "sheet_name" => "3b3",
                "cell" => "F12"
            ],
            [
                "label" => "NN",
                "sheet_name" => "3b3",
                "cell" => "F11"
            ],
            [
                "label" => "NL",
                "sheet_name" => "3b3",
                "cell" => "F10"
            ],

            [
                "label" => "NA1",
                "sheet_name" => "3b5",
                "cell" => "N7"
            ],
            [
                "label" => "NA2",
                "sheet_name" => "3b5",
                "cell" => "N8"
            ],
            [
                "label" => "NA3",
                "sheet_name" => "3b5",
                "cell" => "N9"
            ],
            [
                "label" => "NA4",
                "sheet_name" => "3b5",
                "cell" => "N10"
            ],
            [
                "label" => "NB1",
                "sheet_name" => "3b5",
                "cell" => "N11"
            ],
            [
                "label" => "NB2",
                "sheet_name" => "3b5",
                "cell" => "N12"
            ],
            [
                "label" => "NB3",
                "sheet_name" => "3b5",
                "cell" => "N13"
            ],
            [
                "label" => "NC1",
                "sheet_name" => "3b5",
                "cell" => "N14"
            ],
            [
                "label" => "NC2",
                "sheet_name" => "3b5",
                "cell" => "N15"
            ],
            [
                "label" => "NC3",
                "sheet_name" => "3b5",
                "cell" => "N16"
            ],

            [
                "label" => "NAS",
                "sheet_name" => "3b6",
                "cell" => "J7"
            ],

            [
                "label" => "NAPJ",
                "sheet_name" => "3b7",
                "cell" => "K7"
            ],

            [
                "label" => "NA",
                "sheet_name" => "3b8-1",
                "cell" => "J8"
            ],
            [
                "label" => "NB",
                "sheet_name" => "3b8-2",
                "cell" => "K8"
            ],
            [
                "label" => "NC",
                "sheet_name" => "3b8-3",
                "cell" => "L17"
            ],
            [
                "label" => "ND",
                "sheet_name" => "3b8-4",
                "cell" => "K8"
            ],

            [
                "label" => "DOP",
                "sheet_name" => "4a",
                "cell" => "F12"
            ],
            [
                "label" => "DPD",
                "sheet_name" => "4a",
                "cell" => "F13"
            ],
            [
                "label" => "DPkMD",
                "sheet_name" => "4a",
                "cell" => "F14"
            ],

            [
                "label" => "JP",
                "sheet_name" => "5a-1",
                "cell" => "V17"
            ],
            [
                "label" => "JB",
                "sheet_name" => "5a-1",
                "cell" => "V18"
            ],

            [
                "label" => "NMKI",
                "sheet_name" => "5c",
                "cell" => "V16"
            ],

            [
                "label" => "ai1",
                "sheet_name" => "5d",
                "cell" => "C6"
            ],
            [
                "label" => "bi1",
                "sheet_name" => "5d",
                "cell" => "D6"
            ],
            [
                "label" => "ci1",
                "sheet_name" => "5d",
                "cell" => "E6"
            ],
            [
                "label" => "di1",
                "sheet_name" => "5d",
                "cell" => "F6"
            ],
            [
                "label" => "ai2",
                "sheet_name" => "5d",
                "cell" => "C7"
            ],
            [
                "label" => "bi2",
                "sheet_name" => "5d",
                "cell" => "D7"
            ],
            [
                "label" => "ci2",
                "sheet_name" => "5d",
                "cell" => "E7"
            ],
            [
                "label" => "di2",
                "sheet_name" => "5d",
                "cell" => "F7"
            ],
            [
                "label" => "ai3",
                "sheet_name" => "5d",
                "cell" => "C8"
            ],
            [
                "label" => "bi3",
                "sheet_name" => "5d",
                "cell" => "D8"
            ],
            [
                "label" => "ci3",
                "sheet_name" => "5d",
                "cell" => "E8"
            ],
            [
                "label" => "di3",
                "sheet_name" => "5d",
                "cell" => "F8"
            ],
            [
                "label" => "ai4",
                "sheet_name" => "5d",
                "cell" => "C9"
            ],
            [
                "label" => "bi4",
                "sheet_name" => "5d",
                "cell" => "D9"
            ],
            [
                "label" => "ci4",
                "sheet_name" => "5d",
                "cell" => "E9"
            ],
            [
                "label" => "di4",
                "sheet_name" => "5d",
                "cell" => "F9"
            ],
            [
                "label" => "ai5",
                "sheet_name" => "5d",
                "cell" => "C10"
            ],
            [
                "label" => "bi5",
                "sheet_name" => "5d",
                "cell" => "D10"
            ],
            [
                "label" => "ci5",
                "sheet_name" => "5d",
                "cell" => "E10"
            ],
            [
                "label" => "di5",
                "sheet_name" => "5d",
                "cell" => "F10"
            ],

            [
                "label" => "NPM",
                "sheet_name" => "6a",
                "cell" => "M12"
            ],
            [
                "label" => "NPD",
                "sheet_name" => "3b2",
                "cell" => "F12"
            ],
            
            [
                "label" => "NPkMM",
                "sheet_name" => "7",
                "cell" => "I7"
            ],
            [
                "label" => "NPkMD",
                "sheet_name" => "3b3",
                "cell" => "F13"
            ],

            [
                "label" => "IPKs-2",
                "sheet_name" => "8a",
                "cell" => "E6"
            ],
            [
                "label" => "IPKs-1",
                "sheet_name" => "8a",
                "cell" => "E7"
            ],
            [
                "label" => "IPKs",
                "sheet_name" => "8a",
                "cell" => "E8"
            ],

            [
                "label" => "NI",
                "sheet_name" => "8b1",
                "cell" => "N11"
            ],
            [
                "label" => "NN",
                "sheet_name" => "8b1",
                "cell" => "N12"
            ],
            [
                "label" => "NW",
                "sheet_name" => "8b1",
                "cell" => "N13"
            ],

            [
                "label" => "NI",
                "sheet_name" => "8b2",
                "cell" => "N12"
            ],
            [
                "label" => "NN",
                "sheet_name" => "8b2",
                "cell" => "N13"
            ],
            [
                "label" => "NW",
                "sheet_name" => "8b2",
                "cell" => "N14"
            ],

            [
                "label" => "c",
                "sheet_name" => "8c",
                "cell" => "I32"
            ],[
                "label" => "f",
                "sheet_name" => "8c",
                "cell" => "I35"
            ],[
                "label" => "b",
                "sheet_name" => "8c",
                "cell" => "H32"
            ],[
                "label" => "e",
                "sheet_name" => "8c",
                "cell" => "H35"
            ],[
                "label" => "a",
                "sheet_name" => "8c",
                "cell" => "B32"
            ],[
                "label" => "d",
                "sheet_name" => "8c",
                "cell" => "E35"
            ],

            [
                "label" => "NL",
                "sheet_name" => "8d1",
                "cell" => "B36"
            ],
            [
                "label" => "NJ",
                "sheet_name" => "8d1",
                "cell" => "C36"
            ],
            [
                "label" => "N-WT3",
                "sheet_name" => "8d1",
                "cell" => "E36"
            ],
            [
                "label" => "N-WT36",
                "sheet_name" => "8d1",
                "cell" => "F36"
            ],
            [
                "label" => "N-WT6",
                "sheet_name" => "8d1",
                "cell" => "G36"
            ],

            [
                "label" => "NL",
                "sheet_name" => "8d2",
                "cell" => "B10"
            ],[
                "label" => "NJ",
                "sheet_name" => "8d2",
                "cell" => "C10"
            ],[
                "label" => "PBS-t",
                "sheet_name" => "8d2",
                "cell" => "F10"
            ],

            [
                "label" => "NI",
                "sheet_name" => "8e1",
                "cell" => "G10"
            ],[
                "label" => "NN",
                "sheet_name" => "8e1",
                "cell" => "F10"
            ],[
                "label" => "NW",
                "sheet_name" => "8e1",
                "cell" => "E10"
            ],[
                "label" => "NL",
                "sheet_name" => "8e1",
                "cell" => "B10"
            ],[
                "label" => "NJ",
                "sheet_name" => "8e1",
                "cell" => "D10"
            ],
            [
                "label" => "NJ-tanggapan",
                "sheet_name" => "8e1",
                "cell" => "C10"
            ],

            [
                "label" => "ai1",
                "sheet_name" => "8e2",
                "cell" => "C7"
            ],
            [
                "label" => "bi1",
                "sheet_name" => "8e2",
                "cell" => "D7"
            ],
            [
                "label" => "ci1",
                "sheet_name" => "8e2",
                "cell" => "E7"
            ],
            [
                "label" => "di1",
                "sheet_name" => "8e2",
                "cell" => "F7"
            ],
            [
                "label" => "ai2",
                "sheet_name" => "8e2",
                "cell" => "C8"
            ],
            [
                "label" => "bi2",
                "sheet_name" => "8e2",
                "cell" => "D8"
            ],
            [
                "label" => "ci2",
                "sheet_name" => "8e2",
                "cell" => "E8"
            ],
            [
                "label" => "di2",
                "sheet_name" => "8e2",
                "cell" => "F8"
            ],
            [
                "label" => "ai3",
                "sheet_name" => "8e2",
                "cell" => "C9"
            ],
            [
                "label" => "bi3",
                "sheet_name" => "8e2",
                "cell" => "D9"
            ],
            [
                "label" => "ci3",
                "sheet_name" => "8e2",
                "cell" => "E9"
            ],
            [
                "label" => "di3",
                "sheet_name" => "8e2",
                "cell" => "F9"
            ],
            [
                "label" => "ai4",
                "sheet_name" => "8e2",
                "cell" => "C10"
            ],
            [
                "label" => "bi4",
                "sheet_name" => "8e2",
                "cell" => "D10"
            ],
            [
                "label" => "ci4",
                "sheet_name" => "8e2",
                "cell" => "E10"
            ],
            [
                "label" => "di4",
                "sheet_name" => "8e2",
                "cell" => "F10"
            ],
            [
                "label" => "ai5",
                "sheet_name" => "8e2",
                "cell" => "C11"
            ],
            [
                "label" => "bi5",
                "sheet_name" => "8e2",
                "cell" => "D11"
            ],
            [
                "label" => "ci5",
                "sheet_name" => "8e2",
                "cell" => "E11"
            ],
            [
                "label" => "di5",
                "sheet_name" => "8e2",
                "cell" => "F11"
            ],
            [
                "label" => "ai6",
                "sheet_name" => "8e2",
                "cell" => "C12"
            ],
            [
                "label" => "bi6",
                "sheet_name" => "8e2",
                "cell" => "D12"
            ],
            [
                "label" => "ci6",
                "sheet_name" => "8e2",
                "cell" => "E12"
            ],
            [
                "label" => "di6",
                "sheet_name" => "8e2",
                "cell" => "F12"
            ],
            [
                "label" => "ai7",
                "sheet_name" => "8e2",
                "cell" => "C13"
            ],
            [
                "label" => "bi7",
                "sheet_name" => "8e2",
                "cell" => "D13"
            ],
            [
                "label" => "ci7",
                "sheet_name" => "8e2",
                "cell" => "E13"
            ],
            [
                "label" => "di7",
                "sheet_name" => "8e2",
                "cell" => "F13"
            ],

            [
                "label" => "NA1",
                "sheet_name" => "8f2",
                "cell" => "F7"
            ],
            [
                "label" => "NA2",
                "sheet_name" => "8f2",
                "cell" => "F8"
            ],
            [
                "label" => "NA3",
                "sheet_name" => "8f2",
                "cell" => "F9"
            ],
            [
                "label" => "NA4",
                "sheet_name" => "8f2",
                "cell" => "F10"
            ],
            [
                "label" => "NB1",
                "sheet_name" => "8f2",
                "cell" => "F11"
            ],
            [
                "label" => "NB2",
                "sheet_name" => "8f2",
                "cell" => "F12"
            ],
            [
                "label" => "NB3",
                "sheet_name" => "8f2",
                "cell" => "F13"
            ],
            [
                "label" => "NC1",
                "sheet_name" => "8f2",
                "cell" => "F14"
            ],
            [
                "label" => "NC2",
                "sheet_name" => "8f2",
                "cell" => "F15"
            ],
            [
                "label" => "NC3",
                "sheet_name" => "8f2",
                "cell" => "F16"
            ],

            [
                "label" => "NAPJ",
                "sheet_name" => "8f4",
                "cell" => "L7"
            ],

            [
                "label" => "NA",
                "sheet_name" => "8f5-1",
                "cell" => "J13"
            ],
            [
                "label" => "NB",
                "sheet_name" => "8f5-2",
                "cell" => "K9"
            ],
            [
                "label" => "NC",
                "sheet_name" => "8f5-3",
                "cell" => "L19"
            ],
            [
                "label" => "ND",
                "sheet_name" => "8f5-4",
                "cell" => "J8"
            ],
        ];

        foreach (ProgramStudi::where('jenjang_id', 2)->get() as $key => $prodi)
            foreach ($labeld4 as $item)
                LabelImport::insert([
                    'program_studi_id' => $prodi->id,
                    "label" => $item["label"],
                    "sheet_name" => $item["sheet_name"],
                    "cell" => $item["cell"],
                ]);
    }
}
