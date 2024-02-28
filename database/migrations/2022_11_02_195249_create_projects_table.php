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
        Schema::create('project', function (Blueprint $table) {
            $table->increments('id_project');
            $table->integer('id_client')->unsigned()->nullable();
            $table->integer('id_status')->unsigned()->nullable();
            $table->integer('id_product')->unsigned();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->text('year')->nullable();
            $table->text('owner')->nullable();
            $table->integer('agreed_deadline')->default(0);
            $table->integer('deleted')->default(0);
            $table->text('created_by')->nullable();
            $table->text('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('id_client', 'fk_client_project')
                ->references('id_client')->on('client')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_product', 'fk_product_project')
                ->references('id_product')->on('product')
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
        Schema::dropIfExists('project');
    }
}
