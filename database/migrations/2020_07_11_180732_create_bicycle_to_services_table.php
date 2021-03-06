<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBicycleToServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bicycle_to_services', function (Blueprint $table) {
            $table->id();
            //$table->unsignedBigInteger('bicycle_id');

            //$table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');

            $table->text('description');


            // $table->timestamp('broughtIn_at')->nullable();
            // $table->timestamp('startedToService_at')->nullable();
            // $table->timestamp('readyToTakeIt_at')->nullable();

            // $table->unsignedInteger('workhours')->nullable();

            $table->text('notes', 300)->nullable();

            $table->timestamps();

            //Same:
            //$table->foreign('user_id')->references('id')->on('users');
            //$table->foreignId('user_id')->constrained();
            //$table->foreignId('user_id')->constrained('users');
            //$table->foreignId('user_id')->constrained()->onDelete('cascade');
            //$table->foreignId('user_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bicycle_to_services');
    }
}
