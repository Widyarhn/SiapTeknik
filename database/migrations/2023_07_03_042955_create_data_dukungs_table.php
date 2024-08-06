<?php
use App\Models\MatriksPenilaian;
use App\Models\Jenjang;
use App\Models\Tahun;
use App\Models\Suplemen;
use App\Models\ProgramStudi;
use App\Models\Timeline;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataDukungsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_dukungs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MatriksPenilaian::class)->nullable();
            $table->foreignIdFor(ProgramStudi::class)->nullable();
            $table->foreignIdFor(Tahun::class)->nullable();
            $table->foreignIdFor(Timeline::class)->nullable();
            $table->string('file');
            $table->string('nama');
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
        Schema::dropIfExists('data_dukungs');
    }
}
