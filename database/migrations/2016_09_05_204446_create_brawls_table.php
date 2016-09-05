<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrawlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brawls', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('brawl_type_id')->unsigned();
            $table->date('start_date');

            $table->unique('start_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('brawls');
    }
}
