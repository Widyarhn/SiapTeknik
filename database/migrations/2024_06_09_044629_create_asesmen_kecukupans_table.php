<?php

use App\Models\AspekPenilaian;
use App\Models\MatriksPenilaian;
use App\Models\ProgramStudi;
use App\Models\Tahun;
use App\Models\Timeline;
use App\Models\UserAsesor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsesmenKecukupansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asesmen_kecukupans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MatriksPenilaian::class)->nullable();
            $table->foreignIdFor(UserAsesor::class)->nullable();
            $table->foreignIdFor(Timeline::class)->nullable();
            $table->float('nilai');
            $table->float('upps_nilai')->nullable();
            $table->text('deskripsi');
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
        Schema::dropIfExists('asesmen_kecukupans');
    }
}
