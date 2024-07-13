<?php

use App\Models\User;
use App\Models\ProgramStudi;
use App\Models\Jenjang;
use App\Models\Tahun;
use App\Models\Timeline;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAsesorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_asesors', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Tahun::class);
            $table->foreignIdFor(ProgramStudi::class)->nullable();
            $table->foreignIdFor(Jenjang::class)->nullable();
            $table->foreignIdFor(Timeline::class)->nullable();
            $table->string('jabatan');
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
        Schema::dropIfExists('user_asesors');
    }
}
