<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task', function (Blueprint $table) {
            $table->increments('id_task');
            $table->integer('id_project')->unsigned();
            $table->integer('id_product')->unsigned()->nullable();
            $table->integer('id_directory')->unsigned();
            $table->integer('id_guide')->unsigned()->nullable();
            $table->integer('id_location')->unsigned()->nullable();
            $table->integer('id_practice')->unsigned()->nullable();
            $table->integer('id_contact_bd')->unsigned()->nullable();
            $table->integer('id_senior_consultant')->unsigned()->nullable();
            $table->integer('id_consultant')->unsigned()->nullable();
            $table->integer('id_lds')->unsigned()->nullable();
            $table->integer('id_coordinator')->unsigned()->nullable();
            $table->text('name');
            $table->text('year');
            $table->date('deadline')->nullable();
            $table->date('agreed_deadline')->nullable();
            $table->integer('deleted')->default(0);
            $table->integer('confirmed')->default(0);
            $table->text('created_by')->nullable();
            $table->text('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('id_project', 'fk_project_task')
                ->references('id_project')->on('project')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_product', 'fk_product_task')
                ->references('id_product')->on('product')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_directory', 'fk_directory_task')
                ->references('id_directory')->on('directory')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_guide', 'fk_guide_task')
                ->references('id_guide')->on('guide')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_location', 'fk_location_task')
                ->references('id_location')->on('location')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_practice', 'fk_practice_task')
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
        Schema::dropIfExists('task');
    }
}
