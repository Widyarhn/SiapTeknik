<?php

use App\Models\ProgramStudi;
use App\Models\Jenjang;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Tahun;

class CreateTimelinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timelines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Tahun::class)->nullable();
            $table->foreignIdFor(ProgramStudi::class)->nullable();
            $table->string('kegiatan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_akhir');
            $table->boolean('status')->default(false);
            $table->boolean('selesai')->default(false);
            $table->char('tahap')->default("1");
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
        Schema::dropIfExists('timelines');
    }
}
