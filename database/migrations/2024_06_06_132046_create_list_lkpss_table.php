<?php

use App\Models\Jenjang;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Kriteria;

class CreateListLkpssTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_lkpss', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Kriteria::class)->nullable();
            $table->boolean('d3')->default(true);
            $table->boolean('d4')->default(true);
            $table->text('nama');
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
        Schema::dropIfExists('list_lkpss');
    }
}
