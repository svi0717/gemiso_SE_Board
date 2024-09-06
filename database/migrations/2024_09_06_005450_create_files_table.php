<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file_name');
            $table->text('file_path');
            $table->integer('file_size');
            $table->string('file_type', 50);
            $table->timestamp('upload_date')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('board_id')->nullable();
            $table->foreign('board_id')->references('board_id')->on('gemiso_se.board')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('files');
    }

    };
