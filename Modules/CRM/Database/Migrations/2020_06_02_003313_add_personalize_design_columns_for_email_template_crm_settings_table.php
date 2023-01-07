<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPersonalizeDesignColumnsForEmailTemplateCrmSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crm_settings', function (Blueprint $table) {
            $table->string('logo_image_src',255)->nullable()->after('sending_option');
            $table->string('background_image_src',255)->nullable()->after('sending_option');
            $table->string('top_background_color',255)->nullable()->after('sending_option');
            $table->string('review_number_color',255)->nullable()->after('sending_option');
            $table->string('star_rating_color',255)->nullable()->after('sending_option');
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
            $table->dropColumn('background_image_src');
            $table->dropColumn('top_background_color');
            $table->dropColumn('review_number_color');
            $table->dropColumn('star_rating_color');
        });
    }
}
