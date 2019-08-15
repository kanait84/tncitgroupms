<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_departments', function (Blueprint $table) {
            $table->bigIncrements('sd_id');

            $table->unsignedBigInteger('d_id');
            $table->foreign('d_id')->references('d_id')->on('departments');
            
            $table->string('sd_title',100);
            $table->string('sd_description',100);

         

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
        Schema::dropIfExists('sub_departments');
    }
}
