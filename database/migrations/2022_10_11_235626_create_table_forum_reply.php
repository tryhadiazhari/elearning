<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableForumReply extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_diskusi_reply', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('forum_id');
            $table->string('from', 100);
            $table->text('discussing');
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
        Schema::dropIfExists('forum_diskusi_reply');
    }
}
