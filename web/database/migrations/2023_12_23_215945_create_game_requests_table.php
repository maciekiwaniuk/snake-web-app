<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('game_requests', function (Blueprint $table) {
            $table->id();
            $table->string('secret_hash');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('game_requests');
    }
}
