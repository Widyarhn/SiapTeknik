<?php

use App\Models\Kriteria;
use App\Models\ProgramStudi;
use App\Models\SubKriteria;
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
        Schema::create('import_lkps', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Kriteria::class)->nullable();
            $table->foreignIdFor(ProgramStudi::class)->nullable();
            $table->string('sheet_name');
            $table->longText('json');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_lkps');
    }
};
