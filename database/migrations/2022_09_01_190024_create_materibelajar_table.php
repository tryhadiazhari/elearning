<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateribelajarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materibelajar', function (Blueprint $table) {
            $table->string('materi_id', 50)->primary();
            $table->string('nama_materi', 50);
            $table->text('nama_file');
            $table->text('deskripsi');
            $table->string('mapel_id')->index();
            $table->string('kelas_id', 50)->index();
            $table->string('created_by', 50)->index();
            $table->date('created_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materibelajar');
    }
}
