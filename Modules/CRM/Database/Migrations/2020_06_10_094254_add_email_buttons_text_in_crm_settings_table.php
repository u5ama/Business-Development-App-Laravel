<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailButtonsTextInCrmSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crm_settings', function (Blueprint $table) {
            $table->string('email_positive_anwser',255)->nullable()->after('email_message');
            $table->string('email_negative_anwser',255)->nullable()->after('email_message');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crm_settings', function (Blueprint $table) {
            $table->dropColumn('email_positive_anwser');
            $table->dropColumn('email_negative_anwser');
        });
    }
}
