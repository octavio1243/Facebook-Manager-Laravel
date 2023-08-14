<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacebookAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facebook_accounts', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->useCurrent();
            $table->string('email')->nullable(false)->unique();
            //$table->string('password',30)->nullable(false);
            $table->string('access_token')->nullable(false);
            $table->string('uid')->nullable(false);
            
            $table->string('full_name',50)->nullable(false);
            //$table->string('username',30)->nullable(false)->unique();
            $table->integer('rate');
            
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->unsignedBigInteger('status_id')->nullable(false);
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('status_id')
                ->references('id')
                ->on('statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facebook_accounts');
    }
}
