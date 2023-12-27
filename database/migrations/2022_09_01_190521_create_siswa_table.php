<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->string('siswa_id', 50)->primary();
            $table->string('nisn', 15)->unique();
            $table->string('nis', 20);
            $table->string('nama', 50);
            $table->enum('jk', ['Laki-Laki', 'Perempuan']);
            $table->text('alamat');
            $table->string('telp', 15);
            $table->text('email');
            $table->string('kelas_id', 50)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siswa');
    }
}
