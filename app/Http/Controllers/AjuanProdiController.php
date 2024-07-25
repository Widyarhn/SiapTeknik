<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GenerateDataImport;
use App\Models\Lkps;
use App\Models\DokumenAjuan;
use App\Models\GenerateData;
use App\Models\Led;
use App\Models\ListDocument;
use App\Models\ListLkps;
use App\Models\Tahun;
use Illuminate\Support\Facades\DB;
use App\Models\ProgramStudi;
use App\Models\SuratPengantar;
use App\Models\UserProdi;
use Illuminate\Http\Request;
// use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AjuanProdiController extends Controller
{
    public function prodi(Request $request, $id_prodi)
    {
        // Simpan id_prodi ke session
        session(['id_prodi' => $id_prodi]);

        $program_studi = ProgramStudi::findOrFail($id_prodi);

        $user_prodi = UserProdi::with('tahun')->where("user_id", Auth::user()->id)
            ->where("program_studi_id", $id_prodi)
            ->get();

        $tahun = Tahun::where("is_active", 0);

        $data = [
            "list_d3" => ListLkps::with('kriteria')->where('d3', true)->get(),
        ];

        return view('prodi.dokumen.ajuan.index', $data, ['program_studi' => $program_studi, 'user_prodi' => $user_prodi, 'tahun' => $tahun]);
    }

    public function storeSp(Request $request)
    {
        DB::beginTransaction();

        try {
            $file = $request->file('file');
            $nama_file = $file->getClientOriginalName();
            $nama_file_storage = $file->storeAs('dokumen-prodi/surat-pengantar', $nama_file, 'public');

            $surat_pengantar = new SuratPengantar;
            $surat_pengantar->file = $nama_file_storage;
            $surat_pengantar->program_studi_id = $request->program_studi_id;
            $surat_pengantar->tahun_id = $request->tahun_id;
            $surat_pengantar->status = false;
            $surat_pengantar->save();

            // Simpan ke tabel dokumen_ajuan
            $dokumen_ajuan = new DokumenAjuan;
            $dokumen_ajuan->step_id = $surat_pengantar->id; // menghubungkan dengan ID lkps
            $dokumen_ajuan->program_studi_id = $request->program_studi_id;
            $dokumen_ajuan->kategori = 'surat_pengantar';
            $dokumen_ajuan->pengajuan_ulang = false; // atau nilai default yang sesuai
            $dokumen_ajuan->keterangan = 'Pengajuan Surat Pengantar';
            $dokumen_ajuan->save();

            // Commit transaksi jika semua operasi berhasil
            DB::commit();

            return redirect()->back()->with('success', 'Dokumen Surat Pengantar Berhasil Diunggah');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();

            // Anda juga dapat menambahkan log atau mengirim notifikasi kesalahan di sini jika diperlukan

            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunggah dokumen Surat Pengantar: ' . $e->getMessage());
        }
    }

    public function updateSp(Request $request, $id)
    {
        // Mulai transaksi
        DB::beginTransaction();

        try {
            $surat_pengantar = SuratPengantar::find($id);

            // Jika ada file baru, upload file dan update nama file
            if ($request->hasFile('file')) {
                // Hapus file lama jika ada
                if ($surat_pengantar->file) {
                    // Hapus file lama jika ada
                    Storage::disk('public')->delete($surat_pengantar->file);
                }

                $file = $request->file('file');
                $nama_file = $file->getClientOriginalName();
                $nama_file_storage = $file->storeAs('dokumen-prodi/surat-pengantar', $nama_file, 'public');
            }

            $surat_pengantar->program_studi_id = $request->program_studi_id;
            $surat_pengantar->tahun_id = $request->tahun_id;
            $surat_pengantar->file = $nama_file_storage;
            $surat_pengantar->status = false;
            $surat_pengantar->save();

            // Update data Dokumen Ajuan yang terkait
            $dokumen_ajuan = DokumenAjuan::where('step_id', $surat_pengantar->id)->firstOrFail();
            $dokumen_ajuan->program_studi_id = $request->program_studi_id;
            $dokumen_ajuan->keterangan = 'Update Surat Pengantar';
            $dokumen_ajuan->save();

            // Commit transaksi jika semua operasi berhasil
            DB::commit();

            return redirect()->back()->with('success', 'Dokumen Surat Pengantar Berhasil Diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui dokumen Surat Pengantar: ' . $e->getMessage());
        }
    }

    public function storelkps(Request $request)
    {
        // Mulai transaksi
        DB::beginTransaction();

        try {
            $file = $request->file('file');
            $nama_file = $file->getClientOriginalName();
            $nama_file_storage = $file->storeAs('dokumen-prodi/lkps', $nama_file, 'public');

            $lkps = new Lkps;
            $lkps->file = $nama_file_storage;
            $lkps->program_studi_id = $request->program_studi_id;
            $lkps->tahun_id = $request->tahun_id;
            $lkps->status = false;
            $lkps->save();

            // Simpan ke tabel dokumen_ajuan
            $dokumen_ajuan = new DokumenAjuan;
            $dokumen_ajuan->step_id = $lkps->id; // menghubungkan dengan ID lkps
            $dokumen_ajuan->program_studi_id = $request->program_studi_id;
            $dokumen_ajuan->kategori = 'lkps';
            $dokumen_ajuan->pengajuan_ulang = false; // atau nilai default yang sesuai
            $dokumen_ajuan->keterangan = 'Pengajuan Dokumen LKPS';
            $dokumen_ajuan->save();

            // Commit transaksi jika semua operasi berhasil
            DB::commit();

            return redirect()->back()->with('success', 'Dokumen LKPS Berhasil Diunggah');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunggah dokumen LKPS: ' . $e->getMessage());
        }
    }

    public function updatelkps(Request $request, $id)
    {
        // Mulai transaksi
        DB::beginTransaction();

        try {
            $lkps = Lkps::find($id);
            
            // Jika ada file baru, upload file dan update nama file
            if ($request->hasFile('file')) {
                if ($lkps->file) {
                    Storage::disk('public')->delete($lkps->file);
                }
                $file = $request->file('file');
                $nama_file = $file->getClientOriginalName();
                $nama_file_storage = $file->storeAs('dokumen-prodi/lkps', $nama_file, 'public');
            }

            $lkps->program_studi_id = $request->program_studi_id;
            $lkps->tahun_id = $request->tahun_id;
            $lkps->file = $nama_file_storage;
            $lkps->status = false;
            $lkps->save();

            // Update data Dokumen Ajuan yang terkait
            $dokumen_ajuan = DokumenAjuan::where('step_id', $lkps->id)->firstOrFail();
            $dokumen_ajuan->program_studi_id = $request->program_studi_id;
            $dokumen_ajuan->keterangan = 'Update dokumen lkps';
            $dokumen_ajuan->save();

            // Commit transaksi jika semua operasi berhasil
            DB::commit();

            return redirect()->back()->with('success', 'Dokumen LKPS Berhasil Diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui dokumen LKPS: ' . $e->getMessage());
        }
    }

    public function storeled(Request $request)
    {
        $validatedData = $request->validate(
            [
                'file' => ['required', 'mimes:pdf']
            ],
            [
                'file.mimes' => 'File harus berupa pdf'
            ]
        );

        // Mulai transaksi
        DB::beginTransaction();

        try {
            $file = $request->file('file');
            $nama_file = $file->getClientOriginalName();
            $nama_file_storage = $file->storeAs('dokumen-prodi/led', $nama_file, 'public');

            $led = new Led;
            $led->file = $nama_file_storage;
            $led->program_studi_id = $request->program_studi_id;
            $led->tahun_id = $request->tahun_id;
            $led->status = false;
            $led->save();

            // Simpan ke tabel dokumen_ajuan
            $dokumen_ajuan = new DokumenAjuan;
            $dokumen_ajuan->step_id = $led->id; // menghubungkan dengan ID lkps
            $dokumen_ajuan->program_studi_id = $request->program_studi_id;
            $dokumen_ajuan->kategori = 'led';
            $dokumen_ajuan->pengajuan_ulang = false; // atau nilai default yang sesuai
            $dokumen_ajuan->keterangan = 'Pengajuan Dokumen LED';
            $dokumen_ajuan->save();

            // Commit transaksi jika semua operasi berhasil
            DB::commit();

            return redirect()->back()->with('success', 'Dokumen LED Berhasil Diunggah');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunggah dokumen LED: ' . $e->getMessage());
        }
    }

    public function updateled(Request $request, $id)
    {
        // Mulai transaksi
        DB::beginTransaction();

        try {
            $led = Led::find($id);

            // Jika ada file baru, upload file dan update nama file
            if ($request->hasFile('file')) {
                // Hapus file lama jika ada
                if ($led->file) {
                    Storage::disk('public')->delete($led->file);
                }
                $file = $request->file('file');
                $nama_file = $file->getClientOriginalName();
                $nama_file_storage = $file->storeAs('dokumen-prodi/led', $nama_file, 'public');
            }

            $led->file = $nama_file_storage;
            $led->program_studi_id = $request->program_studi_id;
            $led->tahun_id = $request->tahun_id;
            $led->status = false;
            $led->save();

            // Update data Dokumen Ajuan yang terkait
            $dokumen_ajuan = DokumenAjuan::where('step_id', $led->id)->firstOrFail();
            $dokumen_ajuan->program_studi_id = $request->program_studi_id;
            $dokumen_ajuan->keterangan = 'Update dokumen led';
            $dokumen_ajuan->save();

            // Commit transaksi jika semua operasi berhasil
            DB::commit();

            return redirect()->back()->with('success', 'Dokumen LED Berhasil Diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui dokumen LED: ' . $e->getMessage());
        }
    }

    public function importLkps(Request $request)
    {
        $id_prodi = session('id_prodi');
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
            'list_lkps_id' => 'required',
        ]);
        // Simpan file yang diunggah
        // $file = $request->file('file');
        // $nama_file = $file->getClientOriginalName();
        // $file->move('storage/dokumen_prodi/tabelLkps', $nama_file);

        $path = $request->file('file')->store('dok-import/d3', 'public');
        // Buat entri ListDocument
        $listDocument = ListDocument::create([
            'program_studi_id' => $id_prodi, // Gunakan id_prodi yang diambil dari session
            'list_lkps_id' => $request->list_lkps_id,
            'nama_dokumen' => $path,
        ]);

        $importedData = Excel::toArray(new GenerateDataImport, 'storage/' . $path);
        // Loop through imported data and save to GenerateData
        foreach ($importedData[0] as $row) {
            GenerateData::create([
                'list_document_id' => $listDocument->id,
                'list_lkps_id' => $request->list_lkps_id,
                'json_data' => json_encode($row),
            ]);
        }

        return back()->with('success', 'Data imported and file saved successfully.');
    }
    
    public function history(Request $request, $id_prodi)
    {
        $program_studi = ProgramStudi::findOrFail($id_prodi);

        $user_prodi = UserProdi::where("user_id", Auth::user()->id)
            ->where("program_studi_id", $id_prodi)
            ->get();

        return view('prodi.dokumen.ajuan.history', ['program_studi' => $program_studi, 'user_prodi' => $user_prodi]);
    }
}
