<?php

use Illuminate\Database\Migrations\Migration;

class AddEventIdColumnToMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('maps', function ($table) {
            $table->integer('event_id')->unsigned()->nullable();

            $table->foreign('event_id')->references('id')->on('events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('maps', function ($table) {
            $table->dropForeign('maps_event_id_foreign');
            $table->dropColumn('event_id');
        });
    }
}
