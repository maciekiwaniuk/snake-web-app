<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('api_token')->unique()->nullable()->default(null);
            $table->string('password');
            $table->string('avatar')->default('assets/images/avatar.png');
            $table->integer('permision')->default(0);
            $table->string('last_login_ip')->nullable();
            $table->string('last_login_time')->nullable();
            $table->string('last_user_agent')->nullable();
            $table->boolean('user_banned')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
