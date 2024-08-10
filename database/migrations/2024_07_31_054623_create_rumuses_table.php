<?php

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
        Schema::create('rumuses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SubKriteria::class)->nullable();
            $table->string('rumus');
            $table->float('t_butir')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rumuses');
    }
};
