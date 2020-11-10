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
        // table name: users
        // `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        // `username` VARCHAR(191) NOT NULL COMMENT 'token_key' COLLATE 'utf8mb4_unicode_ci',
        // `password` VARCHAR(191) NOT NULL COMMENT 'token_password' COLLATE 'utf8mb4_unicode_ci',
        // `remember_token` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
        // `created_at` TIMESTAMP NULL DEFAULT NULL,
        // `updated_at` TIMESTAMP NULL DEFAULT NULL,

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements("id")->unsigned();
            $table->string('username', 191)->comment('token_key');
            $table->string('password', 191)->comment('token_password');
            $table->string('remember_token', 191);
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
