<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableForum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_diskusi', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('forum_user_id', 100);
            $table->string('forum_guru_id', 100);
            $table->string('forum_kd_mapel', 100);
            $table->string('forum_kelas_id', 100);
            $table->string('forum_judul');
            $table->longText('forum_text');
            // $table->dateTime('created_date');
            // $table->dateTime('updated_date');
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
        Schema::dropIfExists('forum_diskusi');
    }
}
