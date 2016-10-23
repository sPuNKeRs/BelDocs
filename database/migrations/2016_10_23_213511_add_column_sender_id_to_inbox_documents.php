<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSenderIdToInboxDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inbox_documents', function (Blueprint $table) {
            $table->integer('sender_id')->after('incoming_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inbox_documents', function (Blueprint $table) {
            $table->dropColumn('sender_id');
        });
    }
}
