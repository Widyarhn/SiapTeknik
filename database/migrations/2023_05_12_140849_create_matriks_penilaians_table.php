<?php

use App\Models\Indikator;
use App\Models\ProgramStudi;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\Jenjang;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatriksPenilaiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matriks_penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Kriteria::class)->nullable();
            $table->foreignIdFor(SubKriteria::class)->nullable();
            $table->foreignIdFor(Indikator::class)->nullable();
            $table->foreignIdFor(Jenjang::class)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matriks_penilaians');
    }
}
