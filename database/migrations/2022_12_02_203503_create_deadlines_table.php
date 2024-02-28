<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeadlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deadline', function (Blueprint $table) {
            $table->increments('id_deadline');
            $table->integer('id_deadline_header')->unsigned();
            $table->text('id_guide')->nullable();
            $table->text('id_location')->nullable();
            $table->text('id_practice')->nullable();
            $table->text('directory_status')->nullable();
            $table->date('deadline')->nullable();
            $table->integer('confirmed')->default(0);
            $table->text('created_by')->nullable();
            $table->text('updated_by')->nullable();
            $table->integer('deleted')->default(0);
            $table->timestamps();

            $table->foreign('id_deadline_header', 'fk_deadline_header_deadline')
                ->references('id_deadline_header')->on('deadline_header')
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
        Schema::dropIfExists('deadline');
    }
}
