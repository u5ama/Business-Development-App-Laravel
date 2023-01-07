<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPersonalizeTouchColumnsForEmailTemplateCrmSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crm_settings', function (Blueprint $table) {
            $table->string('company_role',255)->nullable()->after('sending_option');
            $table->string('full_name',255)->nullable()->after('sending_option');
            $table->string('personal_avatar_src',255)->nullable()->after('sending_option');
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
            $table->dropColumn('company_role');
            $table->dropColumn('full_name');
            $table->dropColumn('personal_avatar_src');
        });
    }
}
