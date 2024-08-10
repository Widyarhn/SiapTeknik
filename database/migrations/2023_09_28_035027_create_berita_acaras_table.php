<?php
use App\Models\Jenjang;
use App\Models\ProgramStudi;
use App\Models\Tahun;
use App\Models\Timeline;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeritaAcarasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berita_acaras', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProgramStudi::class)->nullable();
            $table->foreignIdFor(Tahun::class)->nullable();
            $table->string('file');
            $table->enum('status', ['0', '1', '2'])->default('0');
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('berita_acaras');
    }
}
