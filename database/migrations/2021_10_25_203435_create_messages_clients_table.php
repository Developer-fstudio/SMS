<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages_clients', function (Blueprint $table) {
            // $table->bigIncrements('id');
                $table->integer('message_id')->unsigned();
                $table->integer('client_id')->unsigned();
                $table->foreign('message_id')
                ->references('id')
                ->on('messages')
                ->onDelete('cascade');
                $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('cascade');
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
        Schema::dropIfExists('messages_clients');
    }
}
