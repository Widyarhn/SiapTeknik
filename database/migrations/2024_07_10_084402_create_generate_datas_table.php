<?php

use App\Models\ListDocument;
use App\Models\ListLkps;
use App\Models\ProgramStudi;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenerateDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generate_datas', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ListDocument::class)->nullable();
            $table->foreignIdFor(ListLkps::class)->nullable();
            $table->longText('json_data');
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
        Schema::dropIfExists('generate_datas');
    }
}
