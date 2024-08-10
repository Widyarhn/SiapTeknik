<?php

use App\Models\ProgramStudi;
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
        Schema::create('label_imports', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProgramStudi::class)->nullable();
            $table->string('label');
            $table->string('sheet_name');
            $table->string('cell');
            $table->string('nilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('label_imports');
    }
};
