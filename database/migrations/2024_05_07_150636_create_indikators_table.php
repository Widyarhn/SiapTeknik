<?php
use App\Models\SubKriteria;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndikatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indikators', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SubKriteria::class)->nullable();
            $table->text('deskriptor');
            $table->float('bobot');
            $table->text('sangat_baik');
            $table->text('baik');
            $table->text('cukup');
            $table->text('kurang');
            $table->text('sangat_kurang');
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
        Schema::dropIfExists('indikators');
    }
}
