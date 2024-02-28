<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxonomiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxonomy', function (Blueprint $table) {
            $table->increments('id_taxonomy');
            $table->integer('id_directory')->unsigned();
            $table->integer('id_guide')->unsigned()->nullable();
            $table->integer('id_location')->unsigned()->nullable();
            $table->integer('id_practice')->unsigned()->nullable();
            $table->integer('deleted')->default(0);
            $table->text('created_by')->nullable();
            $table->dateTime('last_updated_at')->nullable();
            $table->text('last_updated_by')->nullable();
            $table->timestamps();

            $table->foreign('id_directory', 'fk_directory_taxonomy')
                ->references('id_directory')->on('directory')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_guide', 'fk_guide_taxonomy')
                ->references('id_guide')->on('guide')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_location', 'fk_location_taxonomy')
                ->references('id_location')->on('location')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_practice', 'fk_practice_taxonomy')
                ->references('id_practice')->on('practice')
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
        Schema::dropIfExists('taxonomy');
    }
}
