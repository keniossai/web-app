<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guide', function (Blueprint $table) {
            $table->increments('id_guide');
            $table->integer('id_directory')->unsigned();
            $table->text('name');
            $table->text('description')->nullable();
            $table->integer('deleted')->default(0);
            $table->text('created_by')->nullable();
            $table->dateTime('last_updated_at')->nullable();
            $table->text('last_updated_by')->nullable();
            $table->timestamps();

            $table->foreign('id_directory', 'fk_directory_guide')
                ->references('id_directory')->on('directory')
                ->onDelete('no action')
                ->onUpdate('no action');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guide');
    }
}
