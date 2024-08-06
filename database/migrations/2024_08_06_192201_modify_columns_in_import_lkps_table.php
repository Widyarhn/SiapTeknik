<?php

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
        Schema::table('import_lkps', function (Blueprint $table) {
            $table->string('file')->nullable()->change();
            $table->string('display_name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('import_lkps', function (Blueprint $table) {
            $table->string('file')->nullable(false)->change();
            $table->string('display_name')->nullable(false)->change();
        });
    }
};
