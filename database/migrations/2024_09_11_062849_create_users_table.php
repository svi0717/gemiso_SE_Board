<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * 마이그레이션 실행.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->unique();
            $table->string('password');
            $table->string('name');
            $table->string('phone');
            $table->string('department')->nullable();
            $table->date('reg_date')->nullable();
            $table->date('upd_date')->nullable();
            $table->char('delete_yn', 1)->default('N');
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * 마이그레이션 롤백.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
