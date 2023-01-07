<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_master', function (Blueprint $table) {
            $table->increments('business_id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('practice_name');
            $table->string('phone')->nullable();
            $table->string('website')->nullable();;
            $table->string('address')->nullable();;

            $table->string('practice_status', 10)->nullable();
            $table->integer('discovery_status')->default(0)->comment('0-Not started, 1-Success, 2-Failed, 3-Working', '4-Business Process', '5-Web Process', '6-Reviews Process');

            $table->string('avatar')->nullable();
            $table->string('logo')->nullable();

            $table->string('is_iframe_loaded')->nullable();
            $table->string('user_agent')->nullable();

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
        Schema::dropIfExists('business_master');
    }
}
