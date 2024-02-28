<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directory', function (Blueprint $table) {
            $table->increments('id_directory');
            $table->text('name');
            $table->text('description')->nullable();
            $table->integer('deleted')->default(0);
            $table->text('created_by')->nullable();
            $table->dateTime('last_updated_at')->nullable();
            $table->text('last_updated_by')->nullable();
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
        Schema::dropIfExists('directory');
    }
}
