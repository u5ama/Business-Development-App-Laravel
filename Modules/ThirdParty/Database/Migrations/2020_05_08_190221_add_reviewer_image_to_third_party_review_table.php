<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReviewerImageToThirdPartyReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('third_party_review', function (Blueprint $table) {
            $table->string('reviewer_image',255)->nullable()->after('reviewer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('third_party_review', function (Blueprint $table) {
            $table->dropColumn('reviewer_image');
        });
    }
}
