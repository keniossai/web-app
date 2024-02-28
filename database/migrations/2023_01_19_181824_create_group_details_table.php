<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_detail', function (Blueprint $table) {
            $table->increments('id_groupdetail');
            $table->integer('id_group')->unsigned();
            $table->integer('id_user')->unsigned();
            $table->boolean('is_admin')->nullable();
            $table->integer('deleted')->default(0);
            $table->timestamps();

            $table->foreign('id_group', 'fk_group_group_detail')
                ->references('id_group')->on('group')
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
        Schema::dropIfExists('group_detail');
    }
}
