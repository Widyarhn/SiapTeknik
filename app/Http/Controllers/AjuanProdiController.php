<?php

namespace App\Http\Controllers;

use App\Imports\CustomImportLkps;
use App\Models\Lkps;
use App\Models\DokumenAjuan;
use App\Models\ImportLkps;
use App\Models\Kriteria;
use App\Models\Led;
use App\Models\ListDocument;
use App\Models\ListLkps;
use App\Models\PengajuanDokumen;
use App\Models\Tahun;
use Illuminate\Support\Facades\DB;
use App\Models\ProgramStudi;
use App\Models\SuratPengantar;
use App\Models\UserProdi;
use Carbon\Carbon;
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

        $user_prodi = UserProdi::with('tahun', 'pengajuan_dokumen', 'surat_pengantar', 'lkps', 'led')->where("user_id", Auth::user()->id)
            ->where("program_studi_id", $id_prodi)
            ->get();
        $tahunSaatIni = Carbon::now()->year;
        $pengajuan = PengajuanDokumen::with(['user_prodi' => function ($q) use ($id_prodi) {
            $q->where('program_studi_id', $id_prodi);
            $q->whereHas('tahun', function ($query) {
                $query->where('is_active', true);
            });
        }])->where('status',1 )->first();
        $kriteria = Kriteria::get();
        $importLkps = ImportLkps::with('kriteria')->get();

        return view('prodi.dokumen.ajuan.index', [
            'pengajuan' => $pengajuan,
            'program_studi' => $program_studi,
            'user_prodi' => $user_prodi,
            'now' => $tahunSaatIni,
            'kriteria' => $kriteria,
            'importLkps' => $importLkps,
        ]);
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
            $surat_pengantar->tahun_id = null;
            $surat_pengantar->status = '0';
            $surat_pengantar->save();

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
            $surat_pengantar->tahun_id = null;
            $surat_pengantar->file = $nama_file_storage;
            $surat_pengantar->status = '0';
            $surat_pengantar->keterangan = null;
            $surat_pengantar->save();

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
            $lkps->tahun_id = null;
            $lkps->status = '0';
            $lkps->save();

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
            $lkps->tahun_id = null;
            $lkps->file = $nama_file_storage;
            $lkps->status = '0';
            $lkps->keterangan = null;
            $lkps->save();

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
            $led->tahun_id = null;
            $led->status = '0';
            $led->save();

            // // Simpan ke tabel dokumen_ajuan
            // $dokumen_ajuan = new DokumenAjuan;
            // $dokumen_ajuan->step_id = $led->id; // menghubungkan dengan ID lkps
            // $dokumen_ajuan->program_studi_id = $request->program_studi_id;
            // $dokumen_ajuan->kategori = 'led';
            // $dokumen_ajuan->pengajuan_ulang = false; // atau nilai default yang sesuai
            // $dokumen_ajuan->keterangan = 'Pengajuan Dokumen LED';
            // $dokumen_ajuan->save();

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
            $led->tahun_id = null;
            $led->status = '0';
            $led->keterangan = null;
            $led->save();

            // // Update data Dokumen Ajuan yang terkait
            // $dokumen_ajuan = DokumenAjuan::where('step_id', $led->id)->firstOrFail();
            // $dokumen_ajuan->program_studi_id = $request->program_studi_id;
            // $dokumen_ajuan->keterangan = 'Update dokumen led';
            // $dokumen_ajuan->save();

            // Commit transaksi jika semua operasi berhasil
            DB::commit();

            return redirect()->back()->with('success', 'Dokumen LED Berhasil Diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui dokumen LED: ' . $e->getMessage());
        }
    }

    // public function importLkps(Request $request)
    // {
    //     $id_prodi = session('id_prodi');
    //     $request->validate([
    //         'file' => 'required|mimes:xlsx,csv',
    //     ]);

    //     $path = $request->file('file')->store('dok-import/d3', 'public');

    //     $importedData = Excel::toArray(new GenerateDataImport, 'storage/' . $path);


    //     return back()->with('success', 'Data imported and file saved successfully.');
    // }

    public function importLkps(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
            'id_prodi' => 'required|exists:program_studies,id',
            'id_kriteria' => 'required|exists:kriterias,id',
        ]);
        // dd($request);
        
        try {
            if($request->file('file')){
                $file = $request->file('file');
                // $fileName = $file->getClientOriginalName();
                // $filePath = $file->storeAs('dok-import/d3', $fileName, 'public');
                // dd(Storage::disk('public')->path($filePath));

                // // Pastikan Storage telah diimpor dengan benar
                // $fullPath = Storage::disk('public')->path($filePath);
                // $fileContent = Storage::disk('public')->get($filePath);

                // Buat instance dari CustomImportLkps dan panggil metode import
                $importer = new CustomImportLkps();
                $importer->import($file, $request->id_prodi, $request->id_kriteria);


                return back()->with('success', 'Data imported and file saved successfully.');
            }
            return back()->with('error', 'Terjadi kesalahan');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }

    public function history(Request $request, $id_prodi)
    {
        $program_studi = ProgramStudi::findOrFail($id_prodi);

        $user_prodi = UserProdi::where("user_id", Auth::user()->id)
            ->where("program_studi_id", $id_prodi)
            ->get();

        return view('prodi.dokumen.ajuan.history', ['program_studi' => $program_studi, 'user_prodi' => $user_prodi]);
    }


    public function ajukan(Request $request)
    {
        $request->validate([
            'user_prodi_id' => 'required|integer',
            'led_id' => 'required|integer',
            'lkps_id' => 'required|integer',
            'surat_pengantar_id' => 'required|integer',
            'tahun' => 'required|integer',
            'tanggal_hari_ini' => 'required|date',
        ]);


        // Cek apakah sudah ada pengajuan dokumen dengan ID yang sama
        $existingPengajuan = PengajuanDokumen::where('user_prodi_id', $request->user_prodi_id)
            ->where('led_id', $request->led_id)
            ->where('lkps_id', $request->lkps_id)
            ->where('surat_pengantar_id', $request->surat_pengantar_id)
            ->where('status', '2')
            ->first();

        if ($existingPengajuan) {
            $existingPengajuan->tanggal_ajuan = $request->tanggal_hari_ini;
            $existingPengajuan->status = '1';
            $existingPengajuan->keterangan = 'Pengajuan Ulang Selesai';
            $existingPengajuan->update();

            $tahun = Tahun::where('id', $existingPengajuan->user_prodi->tahun->id)->firstOrFail();
            $tahun->mulai_akreditasi = $request->tanggal_hari_ini;
            $tahun->update();
        } else{
            $tahun = new Tahun;
            $tahun->tahun = $request->tahun;
            $tahun->is_active = true;
            $tahun->mulai_akreditasi = $request->tanggal_hari_ini;
            $tahun->save();

    
            // Membuat entri baru di tabel PengajuanDokumen
            $pengajuan = new PengajuanDokumen;
            $pengajuan->user_prodi_id = $request->user_prodi_id;
            $pengajuan->led_id = $request->led_id;
            $pengajuan->lkps_id = $request->lkps_id;
            $pengajuan->surat_pengantar_id = $request->surat_pengantar_id;
            $pengajuan->tanggal_ajuan = $request->tanggal_hari_ini;
            $pengajuan->status = '1';
            $pengajuan->save();

        }
        // Mengupdate kolom tahun_id di tabel UserProdi
        $user_prodi = UserProdi::findOrFail($request->user_prodi_id);
        $user_prodi->tahun_id = $tahun->id;
        $user_prodi->update();

        // Mengupdate kolom tahun_id di tabel Led
        $led = Led::findOrFail($request->led_id);
        $led->tahun_id = $tahun->id;
        $led->update();

        // Mengupdate kolom tahun_id di tabel Lkps
        $lkps = Lkps::findOrFail($request->lkps_id);
        $lkps->tahun_id = $tahun->id;
        $lkps->update();

        // Mengupdate kolom tahun_id di tabel SuratPengantar
        $surat_pengantar = SuratPengantar::findOrFail($request->surat_pengantar_id);
        $surat_pengantar->tahun_id = $tahun->id;
        $surat_pengantar->update();

        return response()->json(['success' => true, 'message' => 'Pengajuan Akreditasi Program Studi Berhasil.']);
    }
}
