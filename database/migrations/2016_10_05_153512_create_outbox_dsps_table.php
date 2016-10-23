<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutboxDspsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outbox_dsps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dsp_num')->nullable();
            $table->integer('item_number_id')->nullable();
            $table->integer('recipient_id')->nullable();
            $table->string('title')->nullable();
            $table->date('create_date')->nullable();
            $table->date('execute_date')->nullable();
            $table->text('description')->nullable();
            $table->text('resolution')->nullable();
            $table->boolean('status')->nullable();
            $table->integer('author_id');
            $table->boolean('draft')->default(true)->nullable();
            $table->string('slug')->nullable();
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
        Schema::drop('outbox_dsps');
    }
}
