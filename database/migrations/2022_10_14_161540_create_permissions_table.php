<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission', function (Blueprint $table) {
            $table->increments('id_permission');
            $table->integer('id_action')->unsigned();
            $table->integer('id_role')->unsigned();
            $table->tinyInteger('active')->default(1);
            $table->timestamps();

            $table->foreign('id_action', 'fk_action_permission')
                ->references('id_action')->on('action')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_role', 'fk_role_permission')
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
        Schema::dropIfExists('permission');
    }
}
