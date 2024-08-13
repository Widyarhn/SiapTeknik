<?php

use App\Models\Jenjang;
use App\Models\MatriksPenilaian;
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
        Schema::create('anotasi_labels', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Jenjang::class)->nullable();
            $table->foreignIdFor(MatriksPenilaian::class)->nullable();
            $table->string('rumus_label');
            $table->longText('anotasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anotasi_labels');
    }
};
