<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('display_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->string('login_token')->index();
            $table->timestamp('token_expired_at');
            $table->timestamp('last_login_at');
            $table->boolean('status')->default(TRUE);
            $table->tinyInteger('user_role_id')->default(1);
            $table->timestamps();
            $table->text('meta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin_users');
    }
}
