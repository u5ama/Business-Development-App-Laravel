<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppendBusinessTableWithRegion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_master', function (Blueprint $table) {


            // foreign relationship of users table.
            $table->integer('country_id')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();

            // foreign relationship of users table.
            $table->string('state')->nullable();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_master', function($table) {
            $table->dropColumn('country_id');
            $table->dropColumn('city');
            $table->dropColumn('zip_code');
            $table->dropColumn('state');
        });
    }
}
