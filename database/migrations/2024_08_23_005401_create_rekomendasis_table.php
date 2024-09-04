<?php

use App\Models\Kriteria;
use App\Models\ProgramStudi;
use App\Models\Tahun;
use App\Models\UserAsesor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rekomendasis', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Kriteria::class)->nullable();
            $table->foreignIdFor(ProgramStudi::class)->nullable();
            $table->foreignIdFor(Tahun::class)->nullable();
            $table->foreignIdFor(UserAsesor::class)->nullable();
            $table->text('komendasi');
            $table->text('rekomendasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekomendasis');
    }
};
