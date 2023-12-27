<?php

use App\Models\Auth;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login', function (Blueprint $table) {
            $table->string('login_id', 50)->primary()->index();
            $table->string('uname', 50);
            $table->string('password');
            $table->enum('level', ['Admin', 'Guru', 'Siswa']);
            $table->string('user_id', 50)->index();
        });

        Auth::create([
            'login_id' => 1,
            'uname' => 'admin',
            'password' => password_hash('admin', PASSWORD_BCRYPT),
            'level' => 'Admin',
            'user_id' => 0
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('login');
    }
}
