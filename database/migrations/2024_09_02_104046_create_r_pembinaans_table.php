<?php

use App\Models\Tahun;
use App\Models\Kriteria;
use App\Models\UserAsesor;
use App\Models\ProgramStudi;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('r_pembinaans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProgramStudi::class)->nullable();
            $table->foreignIdFor(Tahun::class)->nullable();
            $table->foreignIdFor(UserAsesor::class)->nullable();
            $table->string('file');
            $table->enum('status', ['0', '1', '2'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('r_pembinaans');
    }
};
