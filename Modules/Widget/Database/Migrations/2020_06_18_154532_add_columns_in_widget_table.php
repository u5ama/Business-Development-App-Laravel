<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInWidgetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('widgets', function (Blueprint $table) {
            $table->unsignedTinyInteger('number_of_reviews')->nullable();
            $table->string('sort_review_by')->nullable();
            $table->boolean('schema_markup')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('widgets', function (Blueprint $table) {
            $table->dropColumn('number_of_reviews');
            $table->dropColumn('sort_review_by');
            $table->dropColumn('schema_markup');
        });
    }
}
