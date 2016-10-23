<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEntityNumColumnToInboxDsps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inbox_dsps', function (Blueprint $table) {
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
        Schema::table('inbox_dsps', function (Blueprint $table) {
            $table->dropColumn('entity_num');
        });
    }
}
