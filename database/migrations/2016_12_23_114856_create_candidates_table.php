<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('linkedin_key')->nullable();
            $table->timestamp('registration_date')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->integer('school_id')->unsigned()->nullable();
            $table->integer('education_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('education_id')->references('id')->on('educations');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('candidates');
    }
}
