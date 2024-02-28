<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_history', function (Blueprint $table) {
            $table->increments('id_status_history');
            $table->integer('id_status')->unsigned();
            $table->integer('element_id')->unsigned();
            $table->text('description')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();

            $table->foreign('id_status', 'fk_status_status_history')
                ->references('id_status')->on('status')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->index(['element_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_history');
    }
}
