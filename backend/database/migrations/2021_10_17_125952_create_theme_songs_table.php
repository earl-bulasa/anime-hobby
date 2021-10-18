<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThemeSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('theme_songs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('anime_id');
            $table->foreign('anime_id')->references('id')->on('animes')->onDelete('cascade');
            $table->enum('type', ['Opening', 'Ending']);
            $table->string('title');
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
        Schema::dropIfExists('theme_songs');
    }
}
