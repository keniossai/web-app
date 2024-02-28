<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice', function (Blueprint $table) {
            $table->increments('id_practice');
            $table->integer('id_central_practice')->unsigned();
            $table->integer('id_directory')->unsigned();
            $table->text('name');
            $table->text('created_by')->nullable();
            $table->dateTime('last_updated_at')->nullable();
            $table->text('last_updated_by')->nullable();
            $table->integer('deleted')->default(0);
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
        Schema::dropIfExists('practice');
    }
}
