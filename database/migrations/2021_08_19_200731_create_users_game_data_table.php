<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersGameDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_game_data', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('filename');

            $table->integer('coins');

            $table->string('selected_level');
            $table->string('selected_skins_snake');
            $table->string('selected_skins_fruit');
            $table->string('selected_skins_board');

            $table->boolean('difficulties_medium');
            $table->boolean('difficulties_hard');

            $table->integer('records_easy');
            $table->integer('records_medium');
            $table->integer('records_hard');

            $table->string('inventory_snake_skins');
            $table->string('inventory_fruit_skins');
            $table->string('inventory_board_skins');

            $table->integer('options_fps');
            $table->boolean('options_music');
            $table->boolean('options_effects');
            $table->float('options_volume');

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
        Schema::dropIfExists('users_game_data');
    }
}
