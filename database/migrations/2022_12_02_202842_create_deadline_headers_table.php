<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeadlineHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deadline_header', function (Blueprint $table) {
            $table->increments('id_deadline_header');
            $table->text('id_directory');
            $table->double('year')->nullable();
            $table->text('description')->nullable();
            $table->text('created_by')->nullable();
            $table->text('updated_by')->nullable();
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
        Schema::dropIfExists('deadline_header');
    }
}
