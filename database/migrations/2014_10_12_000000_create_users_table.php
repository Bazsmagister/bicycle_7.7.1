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
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('profile_image')->nullable(); // our profile image field
            $table->string('user_image')->nullable(); // our profile image field

            // $table->string('email');
            $table->char('phone', 30)->nullable();
            $table->string('password')->default('secret');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken()->nullable();

            //i try to implement vew count:
            $table->integer('view_count')->nullable()->default(0);

            // $table->timestamps();
            $table->timestamp('created_at')->default(now());
            // $table->timestamp('updated_at')->default(now());
            $table->timestamp('updated_at')->nullable();

            $table->softDeletes('deleted_at', 0);
            //$table->softDeletesTz('deleted_at', 0); //with Timezone


            // $table->nullableTimestamps(0); //Alias of timestamps() method.

            // $table->unsignedBigInteger('role_id')->index();
            // $table->foreign('role_id')->references('id')->on('roles');
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
