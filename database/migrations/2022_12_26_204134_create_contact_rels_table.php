<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactRelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_rel', function (Blueprint $table) {
            $table->increments('id_contact_rel');
            $table->integer('id_contact')->unsigned();
            $table->integer('element_id')->unsigned();
            $table->text('type_rel');
            $table->text('type_element');
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
        Schema::dropIfExists('contact_rel');
    }
}
