<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('mobile', 100)->unqiue();
            $table->string('type', 100);
            $table->unsignedBigInteger('d_id');
            /*$table->foreign('d_id')->references('d_id')->on('departments');*/
            $table->unsignedBigInteger('sd_id');
            /*$table->foreign('sd_id')->references('sd_id')->on('sub_departments');*/
            $table->string('position', 100);
            $table->string('emp_photo', 100);
            $table->string('emp_sign', 100);
            $table->string('file_type', 100);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
        Schema::dropIfExists('users');
    }
}
