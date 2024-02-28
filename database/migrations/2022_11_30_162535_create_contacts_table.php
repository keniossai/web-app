<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact', function (Blueprint $table) {
            $table->increments('id_contact');
            $table->integer('id_user')->unsigned()->nullable();
            $table->text('profile_pic')->nullable();
            $table->text('name');
            $table->text('last_name')->nullable();
            $table->text('type')->nullable();
            $table->text('email')->nullable();
            $table->text('phone')->nullable();
            $table->text('description')->nullable();
            $table->integer('no_contact')->default(0);
            $table->text('job_title')->nullable();
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
        Schema::dropIfExists('contact');
    }
}
