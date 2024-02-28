<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location', function (Blueprint $table) {
            $table->increments('id_location');
            $table->text('name');
            $table->text('description')->nullable();
            $table->text('lat')->nullable();
            $table->text('long')->nullable();
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
        Schema::dropIfExists('location');
    }
}
