<?php

use App\Models\ProgramStudi;
use App\Models\Jenjang;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Tahun;
use App\Models\UserAsesor;

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
            $table->foreignIdFor(UserAsesor::class)->nullable();
            $table->foreignIdFor(Tahun::class)->nullable();
            $table->foreignIdFor(ProgramStudi::class)->nullable();
            $table->string('kegiatan');
            $table->date('tanggal_mulai');
            $table->date('batas_waktu');
            $table->enum('status', ['0', '1', '2'])->default('0');
            $table->boolean('selesai')->default(false);
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
        Schema::dropIfExists('timelines');
    }
}
