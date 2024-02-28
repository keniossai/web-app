<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client', function (Blueprint $table) {
            $table->increments('id_client');
            $table->text('name');
            $table->text('picture')->nullable();
            $table->text('general_info')->nullable();
            $table->double('phone')->nullable();
            $table->text('website')->nullable();
            $table->text('owner')->nullable();
            $table->text('director')->nullable();
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
        Schema::dropIfExists('client');
    }
}
