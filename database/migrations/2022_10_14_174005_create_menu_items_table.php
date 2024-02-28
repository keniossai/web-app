<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_item', function (Blueprint $table) {
            $table->increments('id_menuitem');
            $table->integer('father_id_menuitem')->unsigned()->nullable();
            $table->integer('id_action')->unsigned()->nullable();
            $table->text('name');
            $table->text('icon')->nullable();
            $table->integer('order')->default(1);
            $table->tinyInteger('active')->default(1);
            $table->timestamps();

            $table->foreign('id_action', 'fk_action_menuitem')
                ->references('id_action')->on('action')
                ->onDelete('no action')
                ->onUpdate('no action');
        });

        Schema::table('menu_item', function (Blueprint $table) {
            $table->foreign('father_id_menuitem', 'fk_fatheridmenuitem_menuitem')
                ->references('id_menuitem')->on('menu_item')
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
        Schema::dropIfExists('menu_item');
    }
}
