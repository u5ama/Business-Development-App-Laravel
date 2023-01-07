<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsForSmsTemplateCrmSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crm_settings', function (Blueprint $table) {
            $table->string('sms_image',255)->nullable()->after('sending_option');
            $table->text('sms_message')->nullable()->after('sending_option');
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
            $table->dropColumn('sms_image');
            $table->dropColumn('sms_message');
        });
    }
}
