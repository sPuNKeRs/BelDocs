<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutboxOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outbox_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('outbox_order_num')->nullable();            
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
        Schema::drop('outbox_orders');
    }
}
