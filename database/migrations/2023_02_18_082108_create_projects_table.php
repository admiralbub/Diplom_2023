<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
           $table->increments('id');
            $table->unsignedInteger('categories_id');
            $table->string('title');
            $table->string('img');
            $table->string('slug')->unique();
            $table->longText('annotation');
            $table->longText('body');
            $table->dateTime('started_at');
            $table->dateTime('started_end');
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
        Schema::dropIfExists('projects');
    }
}
