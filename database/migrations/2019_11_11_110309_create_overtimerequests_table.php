<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOvertimerequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtimerequests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('u_id');
            $table->string('date', 250);
            $table->string('start_time', 250);
            $table->string('end_time', 250);
            $table->text('reason');
            $table->string('mgr_id', 250);
            $table->string('report_uid', 250);
            /*$table->foreign('report_uid')->references('id')->on('users');
            $table->foreign('u_id')->references('id')->on('users');
            $table->foreign('mgr_id')->references('id')->on('users');*/
            $table->string('ot_file', 100);
            $table->string('file_type', 100);
            $table->string('status')->default('pending');
            $table->rememberToken();
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
        Schema::dropIfExists('overtimerequests');
    }
}
