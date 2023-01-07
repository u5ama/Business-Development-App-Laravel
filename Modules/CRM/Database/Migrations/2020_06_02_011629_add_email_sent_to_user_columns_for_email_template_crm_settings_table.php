<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailSentToUserColumnsForEmailTemplateCrmSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crm_settings', function (Blueprint $table) {
            $table->string('email_subject',255)->nullable()->after('sending_option');
            $table->string('email_heading',255)->nullable()->after('sending_option');
            $table->text('email_message')->nullable()->after('sending_option');
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
            $table->dropColumn('logo_image_src');
            $table->dropColumn('email_heading');
            $table->dropColumn('email_message');
        });
    }
}
