<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_role', function (Blueprint $table) {
            $table->increments('id_userrole');
            $table->integer('id_user')->unsigned()->nullable();
            $table->integer('id_role')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('id_user', 'fk_user_userrole')
                ->references('id_user')->on('user')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_role', 'fk_role_userrole')
                ->references('id_role')->on('role')
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
        Schema::dropIfExists('user_role');
    }
}
