<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsAndClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->unique();
            $table->json('settings')->nullable();

            $table->timestamps();
        });

        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('group_id')->nullable();

            $table->string('name')->unique();
            $table->json('settings')->nullable();

            $table->timestamps();

            $table->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->onDelete('set null');
        });

        Schema::create('group_user', function (Blueprint $table) {
            $table->integer('group_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->primary(['group_id', 'user_id']);
        });

        Schema::create('client_user', function (Blueprint $table) {
            $table->integer('client_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->primary(['client_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('groups');
        Schema::dropIfExists('clients');

        Schema::dropIfExists('client_group');
        Schema::dropIfExists('group_user');
        Schema::dropIfExists('client_user');

        Schema::enableForeignKeyConstraints();
    }
}
