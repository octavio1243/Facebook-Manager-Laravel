<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->useCurrent();
            $table->string('name')->nullable(false);
            $table->string('group_id')->nullable(false);
            $table->bigInteger('number_members')->nullable();
            $table->string('url',1024)->nullable(false);
            /*
            $table->unsignedBigInteger('image_id')->nullable();
            $table->foreign('image_id')
                ->references('id')
                ->on('images')
                ->onDelete('set null')
                ->onUpdate('cascade');
            */
            /*
            //NO QUIERO STATUS DEL GRUPO SI CADA USUARIO NO GUARDA TAL GRUPO, SE LLAMA A LA API
            $table->unsignedBigInteger('status_id')->nullable(false);
            $table->foreign('status_id')
                ->references('id')
                ->on('statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            */

            $table->unique(['group_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
}
