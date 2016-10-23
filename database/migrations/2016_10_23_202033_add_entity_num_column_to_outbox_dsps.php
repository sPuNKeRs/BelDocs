<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEntityNumColumnToOutboxDsps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('outbox_dsps', function (Blueprint $table) {
            $table->string('entity_num')->after('dsp_num');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('outbox_dsps', function (Blueprint $table) {
            $table->dropColumn('entity_num');
        });
    }
}
