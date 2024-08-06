<?php

use App\Models\Led;
use App\Models\Lkps;
use App\Models\ProgramStudi;
use App\Models\SuratPengantar;
use App\Models\Timeline;
use App\Models\UserProdi;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuanDokumensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(UserProdi::class)->nullable();
            $table->foreignIdFor(Led::class)->nullable();
            $table->foreignIdFor(Lkps::class)->nullable();
            $table->foreignIdFor(SuratPengantar::class)->nullable();
            $table->date('tanggal_ajuan')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status', ['0', '1', '2'])->default('0');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengajuan_dokumens');
    }
}
